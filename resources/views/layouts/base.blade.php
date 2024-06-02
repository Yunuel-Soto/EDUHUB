<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EDUHUB - @yield('title', 'title_doc')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/libro.png') }}">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/styles/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/home.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/spinner.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/generalPages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/catalogs.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/services.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/schedule.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/assistances.css') }}">

    {{-- External links --}}
    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    {{-- SweeftAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Modals --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

</head>

<body class="body_main">
    <nav id="nav1" class="">
        <ul>
            <li>
                <picture>
                    <img src="{{ asset('assets/img/libro.png') }}" alt="">
                </picture>
                <a href="{{ route('home') }}">EDU HUB</a>
            </li>
            @if (Auth::user()->getRoles('ROLE_SUPERADMIN') or Auth::user()->getRoles('ROLE_SUPERADMIN'))
                <li>
                    <a href="{{ route('indexAssignments') }}">Asignaciones</a>
                    <div class="line"></div>
                </li>
            @endif

            <li id="addServices">
                <a id="">Servicios<img src="{{ asset('assets/img/flecha-hacia-abajo.png') }}"
                        alt=""></a>
                <div class="line"></div>
                <ul id="subServices" class="dropdown hidden">
                    <a href="{{ route('indexHealth') }}">
                        <li>Salud</li>
                    </a>
                </ul>
            </li>

            <li id="addSchedule">
                <a id="">Horario<img src="{{ asset('assets/img/flecha-hacia-abajo.png') }}"
                        alt=""></a>
                <div class="line"></div>
                <ul id="subSchedule" class="dropdown hidden">
                    @if (Auth::user()->getRoles('ROLE_SUPERADMIN') or Auth::user()->getRoles('ROLE_ADMIN'))
                        <a href="{{ route('scheduleTeacher') }}">
                            <li>Profesores</li>
                        </a>
                        <a href="{{ route('scheduleStudent') }}">
                            <li>Alumnos</li>
                        </a>
                    @endif
                    @if (Auth::user()->getRoles('ROLE_TEACHER'))
                        <a href="{{ route('scheduleTeacher') }}">
                            <li>Mi horario</li>
                        </a>
                    @endif
                </ul>
            </li>

            @if (Auth::user()->getRoles('ROLE_TEACHER'))
                <li id="addAssistance">
                    <a href="{{ route('indexAssistances') }}">Asistencias</a>
                    <div class="line"></div>
                </li>

                <li id="addEvaluation">
                    <a href="">Evaluaciones</a>
                    <div class="line"></div>
                </li>
            @endif

            @if (Auth::user()->getRoles('ROLE_SUPERADMIN') or Auth::user()->getRoles('ROLE_ADMIN'))
                <li id="addData">
                    <a id="">Agregar datos<img src="{{ asset('assets/img/flecha-hacia-abajo.png') }}"
                            alt=""> </a>
                    <div class="line"></div>
                    <ul id="subData" class="dropdown hidden">
                        <a href="{{ route('indexUser') }}">
                            <li>Usuarios</li>
                        </a>
                        @if (Auth::user()->getRoles('ROLE_SUPERADMIN'))
                            <a href="{{ route('indexCatalogs') }}">
                                <li>Catalogos</li>
                            </a>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
        <ul>
            <li>
                @auth {{ Auth::user()->teacher->firstName }} {{ Auth::user()->teacher->lastName }} @endauth
                <a href="{{ route('logout') }}">Cerrar sesion</a>
            </li>
        </ul>
    </nav>
    <script>
        $(document).ready(function() {
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            var dropActive = false;
            $('#addData').hover(function(e) {
                e.preventDefault();
                $('#subData').removeClass('hidden');
                $('#subData').addClass('dropdown');
            }, function() {
                $('#subData').addClass('hidden');
                $('#subData').removeClass('dropdown');

            });

            $('#addServices').hover(function(e) {
                e.preventDefault();
                $('#subServices').removeClass('hidden');

            }, function() {
                $('#subServices').addClass('hidden');

            });

            $('#addSchedule').hover(function(e) {
                e.preventDefault();
                $('#subSchedule').removeClass('hidden');
            }, function() {
                $('#subSchedule').addClass('hidden');
            });

        });
    </script>
    @yield('content')
</body>

</html>
