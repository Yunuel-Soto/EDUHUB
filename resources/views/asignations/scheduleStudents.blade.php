@extends('layouts.base')

@section('title', 'Horarios de alumnos')

@section('content')

    <div class="content_schedule">
        <h2>HORARIOS DE <label class="label_color">GRUPOS</label></h2>
        <header>
            <form action="{{ route('scheduleStudent') }}" method="GET">
                <div class="content_input">
                    <select name="groupSelected" id="">
                        <option value="">-- Selecciona grupo --</option>
                        @foreach ($groups as $group)
                            @if ($currentGroup == $group->id)
                                <option selected="selected" value="{{ $group->id }}">{{ $group->name }} -
                                    {{ $group->career->name }}
                                </option>
                            @else
                                <option value="{{ $group->id }}">{{ $group->name }} - {{ $group->career->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="content_btn">
                    <button>Buscar horario</button>
                </div>
            </form>
            @if (count($schedules))
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
                                    @foreach ($schedules as $schedule)
                                        @if ($schedule->day == $day && ($schedule->startTime <= $hour && $schedule->endTime >= $nextHour))
                                            <div class="taskEschedule"
                                                title="{{ $schedule->startTime }} a {{ $schedule->endTime }} - {{ $schedule->day }}">
                                                {{ $schedule->subject->name }} <br>
                                                {{-- {{ $schedule->user->teacher->firstName }} --}}
                                                {{-- {{ $schedule->user->teacher->lastName }} --}}
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
