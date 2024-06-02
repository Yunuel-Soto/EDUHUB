<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN')) {
            return redirect()->route('home');
        }

        $teachers = Teacher::all();
        $subjects = Subject::orderBy('name')->get();
        $groups = Group::all();

        return view('asignations/index', array(
            'teachers' => $teachers,
            'groups' => $groups,
            'subjects' => $subjects,
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN')) {
            return redirect()->route('home');
        }

        $notSave = 0;

        $count = $req->count;
        $days = $req->days;

        $teacher = $req->teacherSchedule;

        $save = true;

        for($i = 0; $i <= $count; $i++) {
            for ($j=0; $j <= $days; $j++) {
                $teacherSchedule = new TeacherSchedule();
                $teacherSchedule->user_id = $teacher;
                $teacherSchedule->startDate = $req->startDate;
                $teacherSchedule->endDate = $req->endDate;

                $save = true;

                if(isset($req->subject[$i])) {
                    $teacherSchedule->subject_id = $req->subject[$i];
                    $teacherSchedule->group_id = $req->group[$i];
                } else {
                    $save = false;
                }

                if(isset($req->day[$i][$j])) {
                    $teacherSchedule->day = $req->day[$i][$j];
                    $teacherSchedule->startTime = $req->startTime[$i][$j];
                    $teacherSchedule->endTime = $req->endTime[$i][$j];
                } else {
                    $save = false;
                }

                if($save) {
                    $teacherSchedules = TeacherSchedule::where('user_id', '=', $teacherSchedule->user->id)
                        ->where('day', '=', $teacherSchedule->day)
                        ->where('startDate', '>=', $teacherSchedule->startDate)
                        ->where('endDate', '<=', $teacherSchedule->endDate)
                        ->where('startTime', '>=', $teacherSchedule->startTime)
                        ->where('endTime', '<=', $teacherSchedule->endTime)
                        ->get();

                    if(count($teacherSchedules) == 0) {

                        $teacherSchedules = TeacherSchedule::where('user_id', '=', $teacherSchedule->user->id)
                            ->where('day', '=', $teacherSchedule->day)
                            ->where('startDate', '>=', $teacherSchedule->startDate)
                            ->where('endDate', '<=', $teacherSchedule->endDate)
                            ->where('startTime', '<=', $teacherSchedule->startTime)
                            ->where('endTime', '>=', $teacherSchedule->endTime)
                            ->get();

                        if(count($teacherSchedules) == 0) {
                            $teacherSchedules = TeacherSchedule::where('user_id', '=', $teacherSchedule->user->id)
                                ->where('day', '=', $teacherSchedule->day)
                                ->where('startDate', '>=', $teacherSchedule->startDate)
                                ->where('endDate', '<=', $teacherSchedule->endDate)
                                ->where('startTime', '<=', $teacherSchedule->startTime)
                                ->where('endTime', '>', $teacherSchedule->startTime)
                                ->get();

                            if(count($teacherSchedules) == 0) {
                                $teacherSchedule->save();
                            } else {
                                $notSave++;
                            }

                        } else {
                            $notSave++;
                        }

                    } else {
                        $notSave++;
                    }
                }
            }
        }

        if($notSave > 0) {
            return redirect()->route('indexAssignments', array('notSave' => $notSave))->with('save_schedule_but_not', 'warning');
        }

        return redirect()->route('indexAssignments')->with('save_schedule', 'success');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function scheduleTeacher(Request $req)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!($user->getRoles('ROLE_TEACHER') || $user->getRoles('ROLE_ADMIN') || $user->getRoles('ROLE_SUPERADMIN'))) {
            return redirect()->route('home');
        }

        $teacher = $req->teacher;

        if($user->getRoles('ROLE_TEACHER')) {
            $teacher = Auth::user()->id;
        }


        $DAYS = [
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado',
            'Domingo'
        ];

        $MONTHS = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];

        $currentDate = date_create(date('Y-m-d'));

        $teachers = Teacher::all();

        $teacherSchedules = TeacherSchedule::where('user_id', $teacher)
            ->where('endDate', '>=', $currentDate)
            ->get();

        $startDate = array();
        $endDate = array();

        foreach ($teacherSchedules as $teacherSchedule) {
            $startDate[] = date_create($teacherSchedule->startDate)->format('d') .' de '. $MONTHS[date_create($teacherSchedule->startDate)->format('m')] .' del '. date_create($teacherSchedule->startDate)->format('Y');
            $endDate[] = date_create($teacherSchedule->endDate)->format('d') .' de '. $MONTHS[date_create($teacherSchedule->endDate)->format('m')] .' del '. date_create($teacherSchedule->endDate)->format('Y');
            break;
        }

        return view('asignations/scheduleTeachers', array(
            'days' => $DAYS,
            'teachers' => $teachers,
            'teacherSchedules' => $teacherSchedules,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentTeacher' => $teacher
        ));
    }

    public function scheduleStudent(Request $req)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!($user->getRoles('ROLE_ADMIN') || $user->getRoles('ROLE_SUPERADMIN'))) {
            return redirect()->route('home');
        }

        $DAYS = [
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado',
            'Domingo'
        ];

        $MONTHS = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];

        $groups = Group::all();

        $currentDate = date_create(date('Y-m-d'));

        $schedules = TeacherSchedule::where('group_id', $req->groupSelected)
            ->where('endDate', '>=', $currentDate)
            ->get();

        $startDate = array();
        $endDate = array();

        foreach ($schedules as $schedule) {
            $startDate[] = date_create($schedule->startDate)->format('d') .' de '. $MONTHS[date_create($schedule->startDate)->format('m')] .' del '. date_create($schedule->startDate)->format('Y');
            $endDate[] = date_create($schedule->endDate)->format('d') .' de '. $MONTHS[date_create($schedule->endDate)->format('m')] .' del '. date_create($schedule->endDate)->format('Y');
            break;
        }

        return view('asignations/scheduleStudents', array(
            'days' => $DAYS,
            'groups' => $groups,
            'schedules' => $schedules,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentGroup' => $req->groupSelected
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $req)
    {
        $userLog = Auth::user();

        if(!$userLog) {
            return redirect()->route('shLogin');
        }

        if(!$userLog->getRoles('ROLE_SUPERADMIN')) {
            return redirect()->route('home');
        }

        $teacherId = $req->teacherSchedule;

        if(!$teacherId) {
            return redirect()->route('indexAssignments')->with('user_not_assign', 'error');
        }

        $currentDate = date_create(date('Y-m-d'));

        $user = User::find($teacherId);

        $teacher = $user->teacher;

        $teacherSchedules = TeacherSchedule::where('user_id', $teacherId)
            ->where('endDate', '>=', $currentDate)
            ->get();

        $groups = Group::all();
        $subjects = Subject::all();

        if(count($teacherSchedules) == 0) {
            return redirect()->route('indexAssignments')->with('user_not_schedule', 'error');
        }

        return view('asignations/updateSchedule', array(
            'teacherSchedules' => $teacherSchedules,
            'teacher' => $teacher,
            'groups' => $groups,
            'subjects' => $subjects,
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req)
    {
        $userLog = Auth::user();

        if(!$userLog) {
            return redirect()->route('shLogin');
        }

        if(!$userLog->getRoles('ROLE_SUPERADMIN')) {
            return redirect()->route('home');
        }

        // updateSchedule

        $user = User::where('id', $req->user_id)->first();
        $schedules = $user->teacherSchedules;

        // Contadores
        $days = $req->days;
        $count = $req->count;

        // Para traer el primer y ultimo id
        $currentCount = array();

        // Eliminar o actualizar asignaciones existentes
        foreach ($schedules as $key => $schedule) {
            $currentCount[] = $schedule->id;

            $schedule->startDate = $req->startDate;
            $schedule->endDate = $req->endDate;


            if(isset($req->group[$schedule->id])) {
                $schedule->group->name = $req->group[$schedule->id];
                $schedule->subject->name = $req->subject[$schedule->id];
                $schedule->save();

                $day = 0;
                foreach ($schedules as $key => $scheduleDay) {

                    if($scheduleDay->subject->id == $schedule->subject->id && $scheduleDay->group->id == $schedule->group->id) {
                        if(isset($req->day[$schedule->id][$day])) {
                            $schedule->day = $req->day[$schedule->id][$day];
                            $schedule->startTime = $req->startTime[$schedule->id][$day];
                            $schedule->endTime = $req->endTime[$schedule->id][$day];
                            $schedule->save();
                        } else {
                            $scheduleDay->delete();
                        }
                        $day = $day + 1;
                    }

                }

            } else {
                $schedule->delete();
            }
        }

        // Agregar las nuevas asignaciones
        $save = true;
        $notSave = 0;

        // Obtener el valor mas bajo
        $firstCount = $currentCount[0];

        // Ordenamos de mayor a menor
        rsort($currentCount);

        for($i = $firstCount; $i <= $count; $i++) {
            for ($j=0; $j <= $days; $j++) {

                $teacherSchedule = new TeacherSchedule();
                $teacherSchedule->user_id = $req->user_id;
                $teacherSchedule->startDate = $req->startDate;
                $teacherSchedule->endDate = $req->endDate;

                $save = true;

                if(isset($req->subject[$i])) {
                    $teacherSchedule->subject_id = $req->subject[$i];
                    $teacherSchedule->group_id = $req->group[$i];
                } else {
                    $save = false;
                }

                if(isset($req->day[$i][$j])) {
                    $teacherSchedule->day = $req->day[$i][$j];
                    $teacherSchedule->startTime = $req->startTime[$i][$j];
                    $teacherSchedule->endTime = $req->endTime[$i][$j];
                } else {
                    $save = false;
                }

                if($save) {
                    $teacherSchedules = TeacherSchedule::where('user_id', '=', $req->user_id)
                        ->where('day', '=', $teacherSchedule->day)
                        ->where('startDate', '>=', $teacherSchedule->startDate)
                        ->where('endDate', '<=', $teacherSchedule->endDate)
                        ->where('startTime', '>=', $teacherSchedule->startTime)
                        ->where('endTime', '<=', $teacherSchedule->endTime)
                        ->get();

                    if(count($teacherSchedules) == 0) {

                        $teacherSchedules = TeacherSchedule::where('user_id', '=', $req->user_id)
                            ->where('day', '=', $teacherSchedule->day)
                            ->where('startDate', '>=', $teacherSchedule->startDate)
                            ->where('endDate', '<=', $teacherSchedule->endDate)
                            ->where('startTime', '<=', $teacherSchedule->startTime)
                            ->where('endTime', '>=', $teacherSchedule->endTime)
                            ->get();

                        if(count($teacherSchedules) == 0) {
                            $teacherSchedules = TeacherSchedule::where('user_id', '=', $req->user_id)
                                ->where('day', '=', $teacherSchedule->day)
                                ->where('startDate', '>=', $teacherSchedule->startDate)
                                ->where('endDate', '<=', $teacherSchedule->endDate)
                                ->where('startTime', '<=', $teacherSchedule->startTime)
                                ->where('endTime', '>', $teacherSchedule->startTime)
                                ->get();

                            if(count($teacherSchedules) == 0) {
                                $teacherSchedule->save();
                            } else {
                                $notSave++;
                            }

                        } else {
                            $notSave++;
                        }

                    } else {
                        $notSave++;
                    }
                }
            }
        }

        if($notSave > 0) {
            return redirect()->route('indexAssignments', array('notSave' => $notSave))->with('save_schedule_but_not', 'warning');
        }

        return redirect()->route('indexAssignments')->with('update_schedule', 'success');
    }

}
