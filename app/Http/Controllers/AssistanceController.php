<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Group;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TeacherSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AssistanceController extends Controller
{
    public function index(Request $req)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_TEACHER') && !$user->getRoles('ROLE_SUPERADMIN')) {
            return redirect()->route('home');
        }


        $currentDate = date_create(date('Y/m/d'));

        // Subconsultas
        // Ordena los resultados de teacherSchedule en base al nombre de los grupos
        $teacherSchedules = TeacherSchedule::orderBy(
            Group::select('name')
                ->whereColumn('id', 'group_id')
                ->orderBy('name')
        )->where('user_id', $user->id)
            ->where('endDate', '>=', $currentDate)
            ->get();

        $teacherSchedulesGroup = TeacherSchedule::where('user_id', $user->id)
            ->where('group_id', $req->group)
            ->where('endDate', '>=', $currentDate)
            ->get();

        $groups = array();
        $currentGroup = array();

        $days = [
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado',
        ];

        $months = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        ];

        if(count($teacherSchedules) == 0) {
            return redirect()->route('home')->with('not_list', 'error');
        }

        foreach ($teacherSchedules as $key => $teacherSchedule) {
            $startDate = $teacherSchedule->startDate;
            $endDate = $teacherSchedule->endDate;
            break;
        }

        $numberDays = date_create($startDate)->diff(date_create($endDate));

        $numberWeeks = $numberDays->format('%a')/7;

        foreach($teacherSchedules as $teacherSchedule) {
            if(!in_array($teacherSchedule->group->id, $currentGroup)) {
                $groups[] = $teacherSchedule->group;
                $currentGroup[] = $teacherSchedule->group->id;
            }
        }

        // Para obtener la lista de alumnos y sus dias
        $daysSchedule = array();
        $group = array();
        $subject = array();

        foreach ($teacherSchedulesGroup as $key => $scheduleGroups) {
            $daysSchedule[] = $scheduleGroups->day;
            $group = $scheduleGroups->group;
            $subject = $scheduleGroups->subject;
        }

        if(!$group) {
            return view('assistances/index', array(
                'groups' => $groups,
                'teacherSchedules' => $teacherSchedules,
                'days' => $days,
                'months' => $months,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'numberDays' => $numberDays->format('%a'),
                'numberWeek' => round($numberWeeks),
                'daysSchedule' => $daysSchedule,
                'students' => $group,
                'groupSelected' => '',
                'subject' => $subject
            ));
        }

        $assistances = Assistance::where('group_id', $group->id)
            ->where('subject_id', $subject->id)
            ->where('teacher_id', $user->teacher->id)
            ->get();

        return view('assistances/index', array(
            'groups' => $groups,
            'teacherSchedules' => $teacherSchedules,
            'days' => $days,
            'months' => $months,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'numberDays' => $numberDays->format('%a'),
            'numberWeek' => round($numberWeeks),
            'daysSchedule' => $daysSchedule,
            'students' => $group->students,
            'groupSelected' => $group->id,
            'assistances' => $assistances,
            'subject' => $subject
        ));
    }

    // Ajax
    public function createAssistance(Request $req, Group $group, Subject $subject, Student $student, $day)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_TEACHER')) {
            return redirect()->route('home');
        }

        $assistance = Assistance::where('student_id', $student->id)
            ->where('group_id', $group->id)
            ->where('subject_id', $subject->id)
            ->where('teacher_id', $user->teacher->id)
            ->where('day', $day)
            ->first();

        if(!$assistance) {
            $assistance = new Assistance();
        }

        $assistance->day = $day;
        $assistance->typeAssistance = $req->get('value');
        $assistance->student_id = $student->id;
        $assistance->group_id = $group->id;
        $assistance->subject_id = $subject->id;
        $assistance->teacher_id = $user->teacher->id;

        return new Response(json_encode(
            array(
                'status' => 'success',
                'msg' => 'Assistance registered successfully'
            )
        ));
    }
}