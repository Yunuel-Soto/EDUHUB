@extends('layouts.base')

@section('title', 'Horario de ' . $teacher->lastName . $teacher->firstName)

@section('content')


@section('content')
    <main class="content_addSchedul">
        <h2>ACTUALIZAR <label class="label_color">HORARIO</label>
        </h2>
        <form method="POST" action="{{ route('scheduleUpdate') }}">
            @csrf
            @method('PUT')
            <input name="count" type="text" id="count" hidden>
            <input name="days" type="text" id="days" hidden>
            <header>
                <div class="content_input">
                    <select name="user_id" id="selectTeacher">
                        <option value="{{ $teacher->user->id }}">{{ $teacher->lastName }} {{ $teacher->firstName }}</option>
                    </select>
                </div>
                <div class="two_input">
                    <div class="content_input">
                        <input type="date" name="startDate" required value="{{ $teacherSchedules[0]->startDate }}" />
                        <label>Fecha de inicio</label>
                    </div>
                    <div class="content_input">
                        <input type="date" name="endDate" required value="{{ $teacherSchedules[0]->endDate }}" />
                        <label>Fecha de termino</label>
                    </div>
                </div>
            </header>
            <section>
                <ul class="content_subjects" id="content_schedule">
                    @php($currentGroup = [])
                    @php($currentSubject = [])
                    @php($totalDays = 0)
                    @foreach ($teacherSchedules as $teacherSchedule)
                        @php($days = 0)

                        @if (!in_array($teacherSchedule->group->id, $currentGroup) || !in_array($teacherSchedule->subject->id, $currentSubject))
                            <li id="{{ $teacherSchedule->id }}">
                                <div id="assig-{{ $teacherSchedule->id }}">
                                    <div class="content_input">
                                        <select name="group[{{ $teacherSchedule->id }}]">
                                            @foreach ($groups as $group)
                                                @if ($group->id == $teacherSchedule->group->id)
                                                    <option value="{{ $group->id }}" selected="selected">
                                                        {{ $group->name }} - {{ $group->career->name }}
                                                    </option>
                                                @endif
                                                <option value="{{ $group->id }}">{{ $group->name }}
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="content_input">
                                        <select name="subject[{{ $teacherSchedule->id }}]">
                                            @foreach ($subjects as $subject)
                                                @if ($subject->id == $teacherSchedule->subject->id)
                                                    <option value="{{ $subject->id }}" selected="selected">
                                                        {{ $subject->name }}
                                                    </option>
                                                @endif
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <ul id="cont_days_{{ $teacherSchedule->id }}">
                                    @foreach ($teacherSchedules as $teacherScheduleDay)
                                        @if (
                                            $teacherScheduleDay->group->id == $teacherSchedule->group->id &&
                                                $teacherScheduleDay->subject->id == $teacherSchedule->subject->id)
                                            <div class="days" id="days_{{ $teacherSchedule->id }}_{{ $days }}">
                                                <div class="content_input">
                                                    <select name="day[{{ $teacherSchedule->id }}][{{ $days }}]"
                                                        class="day">
                                                        <option value="{{ $teacherScheduleDay->day }}" selected="selected">
                                                            {{ $teacherScheduleDay->day }}</option>
                                                        <option value="Lunes">Lunes</option>
                                                        <option value="Martes">Martes</option>
                                                        <option value="Miercoles">Miercoles</option>
                                                        <option value="Jueves">Jueves</option>
                                                        <option value="Viernes">Viernes</option>
                                                        <option value="Sabado">Sabado</option>
                                                    </select>
                                                </div>
                                                <div class="content_input">
                                                    <input type="time" class="startTime"
                                                        name="startTime[{{ $teacherSchedule->id }}][{{ $days }}]"
                                                        value="{{ $teacherScheduleDay->startTime }}">
                                                </div>
                                                <div class="content_input">
                                                    <input type="time" class="endTime"
                                                        name="endTime[{{ $teacherSchedule->id }}][{{ $days }}]"
                                                        value="{{ $teacherScheduleDay->endTime }}">
                                                </div>
                                                <div class="content_btn plus_btn">
                                                    <button class="btn_delete"
                                                        id="removeDay_{{ $teacherSchedule->id }}_{{ $days }}"
                                                        onClick="removeDay({{ $teacherSchedule->id }}, {{ $days }})">-</button>
                                                </div>
                                            </div>
                                            @php($days = $days + 1)
                                            @php($totalDays = $totalDays + 1)
                                        @endif
                                    @endforeach
                                </ul>
                                <div class="content_btn plus_btn">
                                    <button title="Agregar dia" id="addDays-{{ $teacherSchedule->id }}"
                                        onClick="addDays({{ $teacherSchedule->id }}, {{ $days }})">+</button>
                                </div>
                                <div class="content_btn">
                                    <button class="btn_delete" title="Eliminar" id="delete-{{ $teacherSchedule->id }}"
                                        onClick="removeLi({{ $teacherSchedule->id }})">Eliminar asignacion</button>
                                </div>
                            </li>
                        @endif

                        @php($currentGroup[] = $teacherSchedule->group->id)
                        @php($currentSubject[] = $teacherSchedule->subject->id)
                    @endforeach
                </ul>
                <div class="subHeader">
                    <div class="content_btn">
                        <button id="plus">+ Agregar asignacion</button>
                    </div>
                </div>
            </section>

            <div>
                <div class="content_btn"><button class="save">Actualizar</button></div>
            </div>
        </form>
    </main>
    <script>
        var days = {{ $totalDays }};

        // Funcion para los inputs de dia, para marcar conflicto en fechas
        function dayValconflict() {
            $('.day').on('change', function(e) {
                band = false;
                const startTimeInputs = document.querySelectorAll('.startTime');
                const endTimeInputs = document.querySelectorAll('.endTime');
                const dayInputs = document.querySelectorAll('.day');

                dayInputs.forEach((input, i) => {
                    const $startTime = startTimeInputs[i];
                    const $endTime = endTimeInputs[i];
                    const $day = dayInputs[i];

                    const $currentDay = $(this);

                    var name = $currentDay.attr('name');
                    name = name.replace('day', 'startTime');

                    const $currentStartTime = $(`[name="${name}"]`);

                    name = $currentDay.attr('name');
                    name = name.replace('day', 'endTime');

                    const $currentEndTime = $(`[name="${name}"]`);

                    if ((($currentEndTime.val() >= $startTime.value && $currentEndTime.val() < $endTime
                            .value) || ($currentStartTime.val() >= $startTime.value &&
                            $currentStartTime.val() < $endTime)) && ($currentDay.val() == $day.value)) {
                        if (($currentEndTime.attr('name') != $endTime.name) && ($currentDay.attr(
                                'name') != $day.name) && $currentStartTime.attr('name') != $startTime
                            .name) {

                            $currentStartTime.addClass('error');
                            $startTime.classList.add('error');
                            $endTime.classList.add('error');
                            band = true;
                        }
                    } else if (!band) {
                        $currentStartTime.removeClass('error');
                        $currentEndTime.removeClass('error');
                        $startTime.classList.remove('error');
                        $endTime.classList.remove('error');
                    }

                });

            });
        }

        // Funcioon para evaluar conflictos en la hora final
        function endValConflict() {
            $('.endTime').on('change', function(e) {

                var band = false;
                const startTimeInputs = document.querySelectorAll('.startTime');
                const endTimeInputs = document.querySelectorAll('.endTime');
                const dayInputs = document.querySelectorAll('.day');

                endTimeInputs.forEach((input, i) => {
                    const $startTime = startTimeInputs[i];
                    const $endTime = endTimeInputs[i];
                    const $day = dayInputs[i];

                    const $currentEndTime = $(this);

                    var name = $currentEndTime.attr('name');
                    name = name.replace('endTime', 'day');

                    const $currentDay = $(`[name="${name}"]`);

                    name = $currentEndTime.attr('name');
                    name = name.replace('endTime', 'startTime');

                    const $currentStartTime = $(`[name="${name}"]`);

                    if ((($currentEndTime.val() > $startTime.value && $currentEndTime.val() <= $endTime
                            .value) || ($currentStartTime.val() <= $startTime.value && $currentEndTime
                            .val() >= $endTime.value)) && ($currentDay
                            .val() == $day.value)) {

                        if (($currentEndTime.attr('name') != $endTime.name) && ($currentDay.attr('name') !=
                                $day.name)) {
                            console.log($currentDay.attr('name'));
                            console.log($currentDay.val())
                            console.log($day.name);
                            console.log($day.value);

                            $currentEndTime.addClass('error');
                            $startTime.classList.add('error');
                            $endTime.classList.add('error');
                            band = true;
                        }
                    } else if (!band) {
                        $currentEndTime.removeClass('error');
                        $startTime.classList.remove('error');
                        $endTime.classList.remove('error');
                    }
                });
            });
        }

        // Funcioon para evaluar conflictos en la hora inicial
        function startValconflict() {
            $('.startTime').on('change', function(e) {

                var band = false;
                const startTimeInput = document.querySelectorAll('.startTime');
                const endTimeInput = document.querySelectorAll('.endTime');
                const dayInput = document.querySelectorAll('.day');

                startTimeInput.forEach((input, i) => {

                    var startValue = startTimeInput[i].value;
                    var endValue = endTimeInput[i].value;
                    var dayValue = dayInput[i].value;

                    var currentVal = $(this).val();

                    var name = $(this).attr('name');
                    name = name.replace('startTime', 'day');

                    var $currentDayInput = $(`[name="${name}"]`);
                    var currentDayVal = $currentDayInput.val();

                    var $currentInput = $(this);

                    var $startInput = startTimeInput[i];
                    var $endInput = endTimeInput[i];
                    var $dayInput = dayInput[i];

                    if ((currentVal >= startValue && currentVal < endValue) && (currentDayVal ==
                            dayValue)) {
                        if (($currentInput.attr('name') != $startInput.name) && ($currentDayInput.attr(
                                'name') != $dayInput.name)) {
                            $startInput.classList.add('error');
                            $endInput.classList.add('error');
                            $currentInput.addClass('error');
                            band = true;
                        }

                    } else if (!band) {
                        $(this).removeClass('error');
                        $startInput.classList.remove('error');
                        $endInput.classList.remove('error');
                        band = false;
                    }
                });
            });
        }

        // Funcion para remover dia
        function removeDay(count, days) {
            $(`#removeDay_${count}_${days}`).on('click', function(e) {
                e.preventDefault();
            })

            $(`#days_${count}_${days}`).remove();
        }

        // Funcion para agregar dias
        function addDays(count) {

            $(`#addDays-${count}`).on('click', function(e) {
                e.preventDefault();
            });

            days++;

            $('#days').val(days);

            var $formDays = `<div class="days" id="days_${count}_${days}">` +
                '<div class = "content_input">' +
                `<select select name = "day[${count}][${days}]" class="day"> ` +
                '<option value="Lunes">Lunes</option>' +
                '<option value="Martes">Martes</option>' +
                '<option value="Miercoles">Miercoles</option>' +
                '<option value="Jueves">Jueves</option>' +
                '<option value="Viernes">Viernes</option>' +
                '<option value="Sabado">Sabado</option>' +
                '</select>' +
                '</div>' +
                '<div class="content_input">' +
                `<input type="time" name="startTime[${count}][${days}]" class="startTime" required/>` +
                '<label>Hora de inicio</label>' +
                '</div>' +
                `<div class="content_input">` +
                `<input type="time" name="endTime[${count}][${days}]" class="endTime" required/>` +
                '<label>Hora de cierre</label>' +
                '</div>' +
                '<div class="content_btn plus_btn">' +
                `<button class="btn_delete" id="removeDay_${count}_${days}" onClick="removeDay(${count}, ${days})">-</button>` +
                '</div>' +
                '</div>';

            $(`#cont_days_${count}`).append($formDays);

            startValconflict();
            endValConflict();
            dayValconflict();
        }

        // Funcion para remover asignaciones
        function removeLi(count) {
            $(`#delete-${count}`).on('click', function(e) {
                e.preventDefault();
            });

            $(`#${count}`).remove();
        }

        // Jquery que inicia funcionamiento de los botones primarios
        $(document).ready(function() {

            var count = 0;
            @foreach ($teacherSchedules as $teacherSchedule)
                count = {{ $teacherSchedule->id }};
            @endforeach

            $('#count').val(count);
            $('#days').val(days);

            $('.save').on('click', function(e) {
                $('.save').text('');
                var loader = '<span class="loader"></span>';

                $('.save').append(loader);
            });

            $('#plus').on('click', function(e) {
                e.preventDefault();

                var $addScheduleForm = `<li id="${count}">` +
                    `<div id="#assig-${count}">` +
                    '<div class = "content_input" >' +
                    `<select name="group[${count}]">` +
                    @foreach ($groups as $group)
                        '<option value="{{ $group->id }}">{{ $group->name }} - {{ $group->career->name }} </option>' +
                    @endforeach
                '</select>' +
                '</div>' +
                `<div class="content_input">` +
                `<select name="subject[${count}]">` +
                @foreach ($subjects as $subject)
                    '<option value="{{ $subject->id }}">{{ $subject->name }}</option>' +
                @endforeach
                '</select > ' +
                '</div>' +
                '</div>' +
                `<ul id="cont_days_${count}">` +
                `<div class="days" id="days_${count}_${days}">` +
                '<div class = "content_input">' +
                `<select select name = "day[${count}][${days}]" class="day"> ` +
                '<option value="Lunes">Lunes</option>' +
                '<option value="Martes">Martes</option>' +
                '<option value="Miercoles">Miercoles</option>' +
                '<option value="Jueves">Jueves</option>' +
                '<option value="Viernes">Viernes</option>' +
                '<option value="Sabado">Sabado</option>' +
                '</select>' +
                '</div>' +
                '<div class="content_input">' +
                `<input type="time" name="startTime[${count}][${days}]" class="startTime" required/>` +
                '<label>Hora de inicio</label>' +
                '</div>' +
                `<div class="content_input">` +
                `<input type="time" name="endTime[${count}][${days}]" class="endTime" required/>` +
                '<label>Hora de cierre</label>' +
                '</div>' +
                '<div class="content_btn plus_btn">' +
                `<button class="btn_delete" id="removeDay_${count}_${days}" onClick="removeDay(${count}, ${days})">-</button>` +
                '</div>' +
                '</ul>' +
                '</div>' +
                '<div class="content_btn plus_btn">' +
                `<button title="Agregar dia" id="addDays-${count}" onClick="addDays(${count}, ${days})">+</button>` +
                '</div>' +
                `<div class="content_btn">` +
                `<button class="btn_delete" title="Eliminar" id="delete-${count}" onClick="removeLi(${count})">Eliminar asignacion</button>` +
                '</div>' +
                '</li>';

                $('#content_schedule').append($addScheduleForm);

                count++;

                $('#count').val(count);

                startValconflict();
                endValConflict();
                dayValconflict();
            });
        });
    </script>
@stop
