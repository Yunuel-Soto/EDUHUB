@extends('layouts/base')

@section('title', 'Horarios de profesores')

@section('content')

    <div class="content_schedule">
        @if (Auth::user()->getRoles('ROLE_TEACHER'))
            <h2>MÌ <label class="label_color">HORARIO</label></h2>
        @else
            <h2>HORARIOS DE <label class="label_color">PROFESORES</label></h2>
        @endif
        <header>
            @if (Auth::user()->getRoles('ROLE_SUPERADMIN') or Auth::user()->getRoles('ROLE_ADMIN'))
                <form action="{{ route('scheduleTeacher') }}" method="GET">
                    <div class="content_input">
                        <select name="teacher" id="">
                            <option value="">-- Selecciona profesor --</option>
                            @foreach ($teachers as $teacher)
                                @if ($currentTeacher == $teacher->user->id)
                                    <option selected="selected" value="{{ $teacher->user->id }}">{{ $teacher->lastName }}
                                        {{ $teacher->firstName }}
                                    </option>
                                @else
                                    <option value="{{ $teacher->user->id }}">{{ $teacher->lastName }}
                                        {{ $teacher->firstName }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="content_btn">
                        <button>Buscar horario</button>
                    </div>
                </form>
            @endif
            @if (count($teacherSchedules))
                <h5>Del <label class="label_color">{{ $startDate[0] }}</label> al
                    <label class="label_color">{{ $endDate[0] }}</label>
                </h5>
            @else
                <h5>No se encontro ningun horario</h5>
            @endif
        </header>
        <div class="content_calendar table-back">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        @foreach ($days as $day)
                            <th>{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php($j = 0)
                    @php($hours = 7)
                    @for ($i = 0; $hours <= 21; $i++)

                        @if ($hours > 9)
                            @php($hour = $hours . ':' . 0 . 0 . ':' . 0 . 0)
                        @elseif ($hours <= 9)
                            @php($hour = 0 . $hours . ':' . 0 . 0 . ':' . 0 . 0)
                        @endif

                        @if ($hours >= 9)
                            @php($nextHour = $hours + 1 . ':' . 0 . 0 . ':' . 0 . 0)
                        @elseif ($hours < 9)
                            @php($nextHour = 0 . $hours + 1 . ':' . 0 . 0 . ':' . 0 . 0)
                        @endif

                        <tr>
                            <td>{{ $hours }}:00 - {{ $hours + 1 }}:00</td>
                            @foreach ($days as $day)
                                <td class="bodyTB">
                                    @foreach ($teacherSchedules as $teacherSchedule)
                                        @if ($teacherSchedule->day == $day && ($teacherSchedule->startTime <= $hour && $teacherSchedule->endTime >= $nextHour))
                                            <div class="taskEschedule"
                                                title="{{ $teacherSchedule->startTime }} a {{ $teacherSchedule->endTime }} - {{ $teacherSchedule->day }}">
                                                {{ $teacherSchedule->group->name }} <br>
                                                {{ $teacherSchedule->subject->name }}
                                            </div>
                                        @endif
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                        @php($hours = $hours + 1)
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

@stop
