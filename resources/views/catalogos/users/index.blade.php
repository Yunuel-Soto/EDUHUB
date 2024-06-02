@extends('layouts/base')

@section('title', 'Usuarios')

@section('content')

    <main class="main_users animate_start">
        <h2>CONSULTA DE <label class="label_color">USUARIOS</label></h2>
        <div class="content_switch">
            <div class="switch">
                <div class="circle"></div>
            </div>
            <label for="">Profesores</label>
        </div>
        @include('./modals/teachers/createTeacher')
    </main>
    <section class="content_table" id="content_tb">
        <div class="content_btn">
            <a title="Agregar personal administrativo" data-toggle="modal" data-target="#createTeacher">
                <button>
                    + Agregar personal
                </button>
            </a>
        </div>
        <table id="myTable" class="table table-bordered animate_start">
            <thead>
                <tr>
                    <th class="col clave_colum"><label class="label_color">Matricula</label></th>
                    <th class="col firstName_colum"><label class="label_color">Nombre</label></th>
                    <th class="col lastName_colum"><label class="label_color">Apellido</label></th>
                    <th class="col career_colum"><label class="label_color">Carrera</label></th>
                    <th class="col roles_colum"><label class="label_color">Roles</label></th>
                    <th class="col startDate_colum"><label class="label_color">Fecha de inicio</label></th>
                    <th class="col endDate_colum"><label class="label_color">Fecha de termino</label></th>
                    <th class="col actions_colum"><label class="label_color">Acciones</label></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $teacher)
                    @include('modals/teachers/deleteTeacher', ['id' => $teacher->id])
                    @include('modals/teachers/updateTeacher', ['id' => $teacher->id])
                    <tr>
                        <td scope="row" class="clave_colum">{{ $teacher->user->enrollment }}</td>
                        <td class="firstName_colum">{{ $teacher->firstName }}</td>
                        <td class="lastName_colum">{{ $teacher->lastName }}</td>
                        <td class="career_colum">{{ $teacher->career }}</td>
                        <td class="roles_colum">
                            @foreach ($roles[$teacher->user->id] as $rol)
                                {{ $rol }}
                            @endforeach
                        </td>
                        <td class="startDate_colum">{{ $startDate[$teacher->user->id] }}</td>
                        <td class="endDate_colum">{{ $endDate[$teacher->user->id] }}</td>
                        <td class="actions_colum">
                            @if (Auth::user()->getRoles('ROLE_SUPERADMIN') && $teacher->user->id != Auth::user()->id)
                                <a title="Eliminar" data-toggle="modal"
                                    data-target="#deleteTeacher-{{ $teacher->id }}"><img
                                        src="{{ asset('assets/img/borrar.png') }}" alt=""></a>
                            @else
                                <a title="Eliminar desaible"><img src="{{ asset('assets/img/basura.png') }}"
                                        alt=""></a>
                            @endif
                            @if (Auth::user()->getRoles('ROLE_SUPERADMIN') || Auth::user()->id == $teacher->user->id)
                                <a title="Editar" data-toggle="modal" data-target="#updateTeacher-{{ $teacher->id }}"><img
                                        src="{{ asset('assets/img/editar.png') }}" alt=""></a>
                            @else
                                <a title="Editar disable"><img src="{{ asset('assets/img/editar_disable.png') }}"
                                        alt=""></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <section class="content_table" id="content_tb2">
        <div class="content_btn">
            <a title="Agregar Alumno" data-toggle="modal" data-target="#createStudent">
                <button>
                    + Agregar alumno
                </button>
            </a>
        </div>
        <table id="myTable_2" class="table table-bordered animate_start">
            <thead>
                <tr>
                    <th class="col"><label class="label_color">Matricula</label></th>
                    <th class="col"><label class="label_color">Nombre</label></th>
                    <th class="col"><label class="label_color">Apellido</label></th>
                    <th class="col"><label class="label_color">Cuatrimestre en curso</label></th>
                    <th class="col"><label class="label_color">Grupo</label></th>
                    <th class="col"><label class="label_color">Carrera</label></th>
                    <th class="col"><label class="label_color">NSS</label></th>
                    <th class="col"><label class="label_color">Fecha de inicio</label></th>
                    <th class="col"><label class="label_color">Fecha de termino</label></th>
                    <th class="col"><label class="label_color">Roles</label></th>
                    <th class="col"><label class="label_color">Status</label></th>
                    <th class="col"><label class="label_color">Acciones</label></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    @include('modals/students/updateStudent', [$student->id])
                    @include('modals/students/deleteStudent', [$student->id])
                    <tr>
                        <td scope="row">{{ $student->user->enrollment }}</td>
                        <td>{{ $student->firstName }}</td>
                        <td>{{ $student->lastName }}</td>
                        <td>{{ $student->currentQuarter }}</td>
                        <td>{{ $student->group->name }}</td>
                        <td>{{ $student->group->career->name }}</td>
                        <td>{{ $student->NSS }}</td>
                        <td>{{ $startDate[$student->user->id] }}</td>
                        <td>{{ $endDate[$student->user->id] }}</td>
                        <td>{{ $student->status }}</td>
                        <td>
                            @foreach ($roles[$student->user->id] as $rol)
                                {{ $rol }}
                            @endforeach
                        </td>
                        <td>
                            <a title="Eliminar" data-toggle="modal" data-target="#deleteStudent-{{ $student->id }}"><img
                                    src="{{ asset('assets/img/borrar.png') }}" alt=""></a>
                            <a title="Editar" data-toggle="modal" data-target="#updateStudent-{{ $student->id }}"><img
                                    src="{{ asset('assets/img/editar.png') }}" alt=""></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    @include('modals/students/createStudent')

    @if (session()->has('delete_user'))
        @include('modals/generalAlerts/alertSuccess', [
            'title' => 'Usuario eliminado',
            'text' => 'Usuario eliminado con exito',
        ])
    @endif

    @if (session()->has('update_student'))
        @include('modals/generalAlerts/alertSuccess', [
            'title' => 'Accion exitosa',
            'text' => 'El usuario ha sido actualizado con exito',
        ])
    @endif

    @if (session()->has('error_password'))
        @include('modals/generalAlerts/alertError2', [
            'title' => 'Error al actualizar usuario',
            'text' => 'Las contraseñas no coincidieron, verifique sus credenciales antes de registrar el usuario',
        ])
    @endif

    @if (session()->has('error_enrollment'))
        @include('modals/generalAlerts/alertError2', [
            'title' => 'Error al actualizar usuario',
            'text' => 'La clave o matricula ya esta registrada, intente con otra',
        ])
    @endif

    <script>
        $(document).ready(function() {

            // Update student alerts

            @if (session()->has('error_enrollment'))
                $('#alertError2').modal(true);
            @endif

            @if (session()->has('error_password'))
                $('#alertError2').modal(true);
            @endif

            @if (session()->has('update_student'))
                $('#alertSuccess').modal(true);
            @endif

            // -> finish

            @if (session()->has('delete_user'))
                $('#alertSuccess').modal(true);
            @endif

            $('.main_users').removeClass('animate_start');

            $('#myTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/es-MX.json',
                },
            });

            $('#myTable_2').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/es-MX.json',
                },

            });

            $('.dt-length label').text('usuarios por pagina');
            $('.dt-search label').text('Buscar: ');

            $('#content_tb2').addClass('hidden');

            let active = false;
            $('.switch').on('click', function(e) {
                if (active) {
                    $('.switch').removeClass('active');
                    $('.circle').removeClass('active_circle');
                    $('.content_switch label').text('Profesores');

                    $('#content_tb2').addClass('hidden');
                    $('#content_tb').removeClass('hidden');

                    active = false;
                } else {
                    $('.switch').addClass('active');
                    $('.circle').addClass('active_circle');
                    $('.content_switch label').text('Alumnos');

                    $('#content_tb2').removeClass('hidden');
                    $('#content_tb').addClass('hidden');

                    active = true;
                }

            });

            var $content = '<div class="content_tb" id="container"></div>';

            var $buttonAdd = '<div class="content_btn">' +
                '<a title="Agregar personal administrativo" data-toggle="modal" data-target="#createTeacher">' +
                '<button>' +
                '+ Agregar personal' +
                '</button>' +
                '</a >' +
                '</div>';

            var $buttonAdd2 = '<div class="content_btn">' +
                '<a title="Agregar Alumno" data-toggle="modal" data-target="#createStudent">' +
                '<button>' +
                '+ Agregar alumno' +
                '</button>' +
                '</a >' +
                '</div>';

            $('#myTable_wrapper .dt-search').after($content);
            $('#myTable_wrapper .content_tb').append($buttonAdd);

            $('#myTable_2_wrapper .dt-search').before($content);
            $('#myTable_2_wrapper .content_tb').append($buttonAdd2);

        });
    </script>
@stop
