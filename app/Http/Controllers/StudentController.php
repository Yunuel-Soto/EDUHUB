<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        $userLog = Auth::user();

        if(!$userLog) {
            return redirect()->route('shLogin');
        }

        if(!$userLog->getRoles('ROLE_SUPERADMIN') or !$userLog->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $student = new Student();

        $user = new User();

        $user->enrollment = $req->enrollment;

        $userExist = User::where('enrollment', $req->enrollment)->get();

        if(count($userExist) > 0) {
            return redirect()->route('indexUser')->with('error_enrollment', 'error');
        }

        if($req->password != $req->password_confirmation) {
            return redirect()->route('indexUser')->with('error_password', 'error');
        }

        $user->password = Hash::make($req->password);

        $ROLE = "ROLE_USER";

        foreach (Auth::user()->ROLES() as $key => $role) {
            if($req->has($role) && $role != "ROLE_USER") {
                $ROLE = $ROLE . ';' . $role;
            }
        }

        $user->rol = $ROLE;
        $user->save();

        $student->firstName = $req->firstName;
        $student->lastName = $req->lastName;
        $student->currentQuarter = $req->currentQuarter;
        $student->status = "ACTIVE";
        $student->NSS = $req->NSS;
        $student->startDate = $req->startDate;
        $student->endDate = $req->endDate;
        $student->group_id = $req->group;
        $student->user_id = $user->id;

        $student->save();

        return redirect()->route('indexUser')->with('save_user', 'success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Student $student)
    {
        $userLog = Auth::user();

        if(!$userLog) {
            return redirect()->route('shLogin');
        }

        if(!$userLog->getRoles('ROLE_SUPERADMIN') or !$userLog->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $user = $student->user;

        if($req->password) {
            if($req->userLog != $req->password_confirmation) {
                return redirect()->route('indexUser')->with('error_password', 'error');
            }
            $user->password = Hash::make($req->password);
        }


        $userExist = User::where('enrollment', $req->enrollment)->get();

        if(count($userExist) > 0 && $req->enrollment != $user->enrollment) {
            return redirect()->route('indexUser')->with('error_enrollment', 'error');
        }

        $user->enrollment = $req->enrollment;

        $ROLE = "ROLE_USER";

        foreach ($user->ROLES() as $key => $role) {
            if($req->has($role) && $role != "ROLE_USER") {
                $ROLE = $ROLE . ';' . $role;
            }
        }

        $user->rol = $ROLE;
        $user->save();

        $student->firstName = $req->firstName;
        $student->lastName = $req->lastName;
        $student->currentQuarter = $req->currentQuarter;
        $student->status = $req->status;
        $student->NSS = $req->NSS;
        $student->startDate = $req->startDate;
        $student->endDate = $req->endDate;
        $student->group_id = $req->group;
        $student->save();

        return redirect()->route('indexUser')->with('update_student', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $student->delete();

        return redirect()->route('indexUser')->with('delete_user', 'success');
    }
}