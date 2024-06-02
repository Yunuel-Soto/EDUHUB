@extends('layouts/base')

@section('title', 'Asignaciones')

@section('content')
    <main class="content_addSchedul">
        <h2>ASIGNAR <label class="label_color">HORARIO</label></h2>
        <form method="POST" action="{{ route('createSchedule') }}">
            @csrf
            <input name="count" type="text" id="count" hidden>
            <input name="days" type="text" id="days" hidden>
            <header>
                <div class="content_input">
                    <select name="teacherSchedule" id="selectTeacher">
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->user->id }}">{{ $teacher->lastName }}
                                {{ $teacher->firstName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="two_input">
                    <div class="content_input">
                        <input type="date" name="startDate" required />
                        <label>Fecha de inicio</label>
                    </div>
                    <div class="content_input">
                        <input type="date" name="endDate" required />
                        <label>Fecha de termino</label>
                    </div>
                </div>

                <div class="content_btn">
                    <a title="Actualizar datos" data-toggle="modal" data-target="#scheduleUpdate">Actualizar
                        Calendario</a>
                </div>
            </header>
            <section>
                <ul class="content_subjects" id="content_schedule"></ul>
                <div class="subHeader">
                    <div class="content_btn">
                        <button id="plus">+ Agregar asignacion</button>
                    </div>
                </div>
            </section>

            <div>
                <div class="content_btn"><button class="save">Guardar</button></div>
            </div>
        </form>
    </main>
    @include('modals/schedules/selectedUser', ['teachers' => $teachers])


    @if (session()->has('save_schedule'))
        @include('modals/generalAlerts/alertSuccess', [
            'title' => 'Horario cargado',
            'text' => 'Horario actualizado con exito',
        ])
    @endif

    @if (session()->has('save_schedule_but_not'))
        @include('modals/generalAlerts/alertSuccess', [
            'title' => 'Horario cargado',
            'text' =>
                'Horario actualizado con exito, sin embargo, algunas de tus asignaciones no se guardaron debido a que chocaban con otras asignaciones',
        ])
    @endif

    @if (session()->has('user_not_schedule'))
        @include('modals/generalAlerts/alertError2', [
            'title' => 'Error al buscar horario',
            'text' =>
                'La persona a la que intenta actualizar el horario aun no tiene ninguna asignacion. Creele una asignacion antes de actualizar.',
        ])
    @endif

    @if (session()->has('update_schedule'))
        @include('modals/generalAlerts/alertSuccess', [
            'title' => 'Horario actualizado con exito',
            'text' => 'El horario ha sido actualizado correctamente.',
        ])
    @endif

    @if (session()->has('user_not_assign'))
        @include('modals/generalAlerts/alertError2', [
            'title' => 'Error',
            'text' => 'No se ha seleccionado ningun usuario al momento de ir al panel de actualizacion.',
        ])
    @endif

    <script>
        @if (session()->has('save_schedule'))
            $('#alertSuccess').modal(true);
        @endif

        @if (session()->has('save_schedule_but_not'))
            $('#alertSuccess').modal(true);
        @endif

        @if (session()->has('user_not_schedule'))
            $('#alertError2').modal(true);
        @endif

        @if (session()->has('update_schedule'))
            $('#alertSuccess').modal(true)
        @endif

        @if (session()->has('user_not_assign'))
            $('#alertError2').modal(true);
        @endif

        // Variable global
        var days = 0;

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

        function removeDay(count, days) {
            $(`#removeDay_${count}_${days}`).on('click', function(e) {
                e.preventDefault();
            })

            $(`#days_${count}_${days}`).remove();
        }

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

        function removeLi(count) {
            $(`#delete-${count}`).on('click', function(e) {
                e.preventDefault();
            });

            $(`#${count}`).remove();
        }

        $(document).ready(function() {
            var count = 0;

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
