<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherLogValidation;
use App\Http\Requests\TeacherSingInValidate;
use App\Http\Requests\TeacherUpdateValidate;
use App\Http\Requests\TeacherValidation;
use App\Models\Group;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class TeacherController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function login(TeacherLogValidation $req)
    {
        $credentials = [
            "enrollment" => $req->enrollment,
            "password" => $req->password,
        ];


        if(Auth::attempt($credentials)) {

            $req->session()->regenerate();

            return redirect()->intended(route('home'));

        } else {

            $error_msg = 'session_faild';
            return redirect()->route('shLogin')->with($error_msg, 'abc');

        }
    }


    public function singIn(TeacherSingInValidate $req)
    {
        $teacher = new Teacher();
        $user = new User();

        $director = [
            'enrollment' => 3554,
            'startDate' => date_create(date('2008-11-01')),
        ];

        $userExist = User::where('enrollment', $req->enrollment)->get();

        if(count($userExist) > 0) {
            return redirect()->route('singIn')->with('identifyNumber_used', 'abc');

        }

        $user->enrollment = $req->enrollment;
        $teacher->firstName = $req->firstName;
        $teacher->lastName = $req->lastName;
        $teacher->career = $req->career;
        $user->password = $req->password;
        $teacher->startDate = $director['startDate'];
        $user->rol = 'ROLE_USER;ROLE_ADMIN;ROLE_SUPERADMIN';

        // La encripta
        $user->password = Hash::make($req->password);

        if($req->password != $req->password_confirmation) {
            return redirect()->route('singIn')->with('password_incorrect', 'abc');
        }

        if($director['enrollment'] != $user->enrollment) {
            return redirect()->route('singIn')->with('identifyNumber_not_found', 'abc');
        }

        $user->save();

        $teacher->user_id = $user->id;

        $teacher->save();

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(Request $req)
    {
        Auth::logout();

        $req->session()->regenerateToken();

        return redirect()->route('shLogin');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function registerTeacher(TeacherValidation $req)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        $teacher = new Teacher();
        $user = new User();

        $userExist = User::where('enrollment', $req->enrollment)->get();

        if(count($userExist) > 0) {
            return redirect()->route('indexUser')->with('identifyNumber_used', 'abc');
        }

        $user->enrollment = $req->enrollment;
        $teacher->firstName = $req->firstName;
        $teacher->lastName = $req->lastName;
        $teacher->career = $req->career;
        $user->password = $req->password;
        $teacher->startDate = $req->startDate;

        $ROLE = "ROLE_USER";

        foreach (Auth::user()->ROLES() as $key => $role) {
            if($req->has($role) && $role != "ROLE_USER") {
                $ROLE = $ROLE . ';' . $role;
            }
        }

        $user->rol = $ROLE;

        // La encripta
        $user->password = Hash::make($req->password);

        if($req->password != $req->password_confirmation) {
            return redirect()->route('indexUser')->with('password_incorrect', 'abc');
        }

        $user->save();

        $teacher->user_id = $user->id;

        $teacher->save();

        return redirect()->route('indexUser')->with('saved_success', '123');
    }

    /**
     * Update the specified resource in storage.
     */
    public function index()
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if (!$user->getRoles('ROLE_ADMIN') && !$user->getRoles('ROLE_SUPERADMIN')) {
            return redirect()->route('home');
        }

        $teachers = Teacher::all();
        $students = Student::all();
        $groups = Group::all();

        $roles = array();
        $startDate = array();
        $endDate = array();

        foreach ($teachers as $key => $teacher) {
            $roles[$teacher->user->id] = preg_split("/[;]/", $teacher->user->rol);
            $startDate[$teacher->user->id] = date_create($teacher->startDate)->format('d/m/Y');
            if($teacher->endDate) {
                $endDate[$teacher->user->id] = date_create($teacher->endDate)->format('d/m/Y');
            } else {
                $endDate[$teacher->user->id] = 'NO DEFINIDA';
            }
        }

        foreach ($students as $key => $student) {
            $roles[$student->user->id] = preg_split("/[;]/", $student->user->rol);
            $startDate[$student->user->id] = date_create($student->startDate)->format('d/m/Y');
            if($student->endDate) {
                $endDate[$student->user->id] = date_create($student->endDate)->format('d/m/Y');
            } else {
                $endDate[$student->user->id] = 'NO DEFINIDA';
            }
        }

        return view('catalogos/users/index', array(
            'teachers' => $teachers,
            'students' => $students,
            'groups' => $groups,
            'roles' => $roles,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('login');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $user = $teacher->user;

        $user->delete();

        return redirect()->route('indexUser')->with('delete_user', 'abc');
    }

    public function update(TeacherUpdateValidate $req, Teacher $teacher)
    {
        $userLog = Auth::user();

        if(!$userLog) {
            return redirect()->route('login');
        }

        if(!$userLog->getRoles('ROLE_SUPERADMIN') or !$userLog->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $user = $teacher->user();

        $ROLE = "ROLE_USER";

        foreach (Auth::user()->ROLES() as $key => $role) {
            if($req->has($role . '-'. $teacher->id) && $role != "ROLE_USER") {
                $ROLE = $ROLE . ';' . $role;
            }
        }

        if($req->password || $req->password_confirmation) {
            if($req->password != $req->password_confirmation) {
                // save new password
                $user->update([
                    "enrollment" => $req->enrollment,
                    "rol" => $ROLE,
                    "password" => Hash::make($req->password),
                    "updated_at" => date_create(date('Y-m-d')),
                ]);
            }
        } else {
            $user->update([
                "enrollment" => $req->enrollment,
                "rol" => $ROLE,
                "updated_at" => date_create(date('Y-m-d  H:i:s')),
            ]);
        }

        $teacher->update([
            "firstName" => $req->firstName,
            "lastName" => $req->lastName,
            "career" => $req->career,
            "startDate" => $req->startDate,
            "endDate" => $req->endDate,
            "updated_at" => date_create(date('Y-m-d H:i:s')),
        ]);

        return redirect()->route('indexUser')->with('save_success', 'abc');
    }
}
