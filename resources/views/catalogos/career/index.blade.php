@extends('layouts/base')

@section('title', 'Catalogos')

@section('content')

    <main class="content_catalogs animate_start">
        <h2>CATALÒGOS</h2>
        <div class="next_content">
            <img id="flecha1" src="{{ asset('assets/img/flecha-izquierda.png') }}" alt="">
            <div>
                <img id="line1" src="{{ asset('assets/img/linea-gris.png') }}" alt="">
                <img id="line2" src="{{ asset('assets/img/linea.png') }}" alt="">
                <img id="line3" src="{{ asset('assets/img/linea-gris.png') }}" alt="">
            </div>
            <img id="flecha2" src="{{ asset('assets/img/flecha-derecha.png') }}" alt="">
        </div>
        <div class="content_sections">
            @include('modals/careers/createCareer')
            <section class="content_table" id="sec1">
                <h3><label class="label_color">Carreras</label></h3>
                <div class="content_btn">
                    <a title="Agregar Carrera" data-toggle="modal" data-target="#createCareer">
                        <button>
                            + Agregar Carrera
                        </button>
                    </a>
                </div>
                <table id="myTable" class="table table-bordered animate_start">
                    <thead>
                        <tr>
                            <th class="col id_colum"><label class="label_color">Id</label></th>
                            <th class="col career_colum"><label class="label_color">Carrera</label></th>
                            <th class="col actions_colum"><label class="label_color">Acciones</label></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($careers as $career)
                            @include('modals/careers/deleteCareer', ['id' => $career->id])
                            @include('modals/careers/updateCareer', ['id' => $career->id])
                            @include('modals/careers/infoCareer')
                            <tr>
                                <td class="id_colum">{{ $career->id }}</td>
                                <td class="career_colum">{{ $career->name }}</td>
                                <td class="actions_colum">
                                    <a title="Eliminar" data-toggle="modal"
                                        data-target="#deleteCareer-{{ $career->id }}"><img
                                            src="{{ asset('assets/img/borrar.png') }}" alt=""></a>
                                    <a title="Editar" data-toggle="modal"
                                        data-target="#updateCareer-{{ $career->id }}"><img
                                            src="{{ asset('assets/img/editar.png') }}" alt=""></a>
                                    <a title="Informacion" data-toggle="modal"
                                        data-target="#infoCareer-{{ $career->id }}"><img
                                            src="{{ asset('assets/img/boton-de-informacion.png') }}" alt=""></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
            <section class="hidden content_table" id="sec2">
                @include('modals/subjects/createSubject')
                <h3><label class="label_color">Materias</label></h3>
                <div class="content_btn">
                    <a title="Agregar Materia" data-toggle="modal" data-target="#createSubject">
                        <button>
                            + Agregar Materia
                        </button>
                    </a>
                </div>
                <table id="myTable_2" class="table table-bordered animate_start">
                    <thead>
                        <tr>
                            <th class="col id_colum"><label class="label_color">Id</label></th>
                            <th class="col career_colum"><label class="label_color">Materia</label></th>
                            <th class="col actions_colum"><label class="label_color">Acciones</label></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                            <tr>
                                <td class="id_colum">{{ $subject->id }}</td>
                                <td class="subject_colum">{{ $subject->name }}</td>
                                <td class="actions_colum">
                                    <a title="Eliminar" data-toggle="modal"
                                        data-target="#deleteSubject-{{ $subject->id }}"><img
                                            src="{{ asset('assets/img/borrar.png') }}" alt=""></a>
                                    <a title="Editar" data-toggle="modal"
                                        data-target="#updateSubject-{{ $subject->id }}"><img
                                            src="{{ asset('assets/img/editar.png') }}" alt=""></a>
                                </td>
                            </tr>
                            @include('modals/subjects/updateSubject', [$subject->id])
                            @include('modals/subjects/deleteSubject', [$subject->id])
                        @endforeach
                    </tbody>
                </table>
            </section>
            <section class="hidden content_table" id="sec3">
                <h3><label class="label_color">Grupos</label></h3>
                <div class="content_btn">
                    <a title="Agregar Grupo" data-toggle="modal" data-target="#createGroup">
                        <button>
                            + Agregar Grupo
                        </button>
                    </a>
                </div>
                <table id="myTable_3" class="table table-bordered animate_start">
                    <thead>
                        <tr>
                            <th class="col id_colum"><label class="label_color">Id</label></th>
                            <th class="col career_colum"><label class="label_color">Grupo</label></th>
                            <th class="col career_colum"><label class="label_color">Cuota</label></th>
                            <th class="col career_colum"><label class="label_color">Duracion</label></th>
                            <th class="col actions_colum"><label class="label_color">Acciones</label></th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('modals/groups/createGroup')
                        @foreach ($groups as $group)
                            @include('modals/groups/deleteGroup', [$group->id])
                            @include('modals/groups/updateGroup', [$group->id])
                            <tr>
                                <td class="id_colum">{{ $group->id }}</td>
                                <td class="subject_colum">{{ $group->name }}</td>
                                <td class="subject_colum">{{ $group->quota }}</td>
                                <td class="subject_colum">{{ $group->duration }}</td>
                                <td class="actions_colum">
                                    <a title="Eliminar" data-toggle="modal"
                                        data-target="#deleteGroup-{{ $group->id }}"><img
                                            src="{{ asset('assets/img/borrar.png') }}" alt=""></a>
                                    <a title="Editar" data-toggle="modal"
                                        data-target="#updateGroup-{{ $group->id }}"><img
                                            src="{{ asset('assets/img/editar.png') }}" alt=""></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </main>

    @if (session()->has('saved_group'))
        @include('modals/generalAlerts/alertSuccess', [
            'title' => 'Nuevo grupo',
            'text' => 'Grupo creado con exito',
        ])
    @endif
    @if (session()->has('saved_subject'))
        @include('modals/generalAlerts/alertSuccess', [
            'title' => 'Nueva materia',
            'text' => 'Materia creado con exito',
        ])
    @endif
    @if (session()->has('saved_career'))
        @include('modals/generalAlerts/alertSuccess', [
            'title' => 'Nueva carrera',
            'text' => 'Carrera creado con exito',
        ])
    @endif

    <script>
        $(document).ready(function() {
            @if (session()->has('saved_group'))
                $('#alertSuccess').modal(true);
            @endif
            @if (session()->has('saved_subject'))
                $('#alertSuccess').modal(true);
            @endif
            @if (session()->has('saved_career'))
                $('#alertSuccess').modal(true);
            @endif

            $('.content_catalogs').removeClass('animate_start');

            var table = new DataTable('#myTable', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/es-MX.json',
                },
            });

            var table = new DataTable('#myTable_2', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/es-MX.json',
                },
            });
            var table = new DataTable('#myTable_3', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/es-MX.json',
                },
            });

            var $content = '<div class="content_tb"></div>';

            var $buttonAdd = '<div class="content_btn_tb">' +
                '<a title="Agregar Carrera" data-toggle="modal" data-target="#createCareer">' +
                '<button>' +
                '+ Agregar Carrera' +
                '</button>' +
                '</a >' +
                '</div>';

            var $buttonAdd2 = '<div class="content_btn_tb">' +
                '<a title="Agregar Materia" data-toggle="modal" data-target="#createSubject">' +
                '<button>' +
                '+ Agregar Materia' +
                '</button>' +
                '</a >' +
                '</div>';

            var $buttonAdd3 = '<div class="content_btn_tb">' +
                '<a title="Agregar Grupo" data-toggle="modal" data-target="#createGroup">' +
                '<button>' +
                '+ Agregar Grupo' +
                '</button>' +
                '</a >' +
                '</div>';

            $('#myTable_wrapper .dt-search').before($content);
            $('#myTable_wrapper .content_tb').append($buttonAdd);

            $('#myTable_2_wrapper .dt-search').before($content);
            $('#myTable_2_wrapper .content_tb').append($buttonAdd2);

            $('#myTable_3_wrapper .dt-search').before($content);
            $('#myTable_3_wrapper .content_tb').append($buttonAdd3);

            var page = 2;

            $('#flecha1').on('click', function(e) {
                if (page == 2) {
                    $('#sec2').removeClass('hidden');
                    $('#sec1').addClass('hidden');
                    $('#line1').attr('src', '{{ asset('assets/img/linea.png') }}');
                    $('#line2').attr('src', '{{ asset('assets/img/linea-gris.png') }}');
                    $('#line3').attr('src', '{{ asset('assets/img/linea-gris.png') }}');
                    page = 1;
                }
                if (page == 3) {
                    $('#sec2').addClass('hidden');
                    $('#sec1').removeClass('hidden');
                    $('#sec3').addClass('hidden');
                    $('#line1').attr('src', '{{ asset('assets/img/linea-gris.png') }}');
                    $('#line2').attr('src', '{{ asset('assets/img/linea.png') }}');
                    $('#line3').attr('src', '{{ asset('assets/img/linea-gris.png') }}');
                    page = 2;
                }
            });

            $('#flecha2').on('click', function(e) {
                if (page == 2) {
                    page = 3;
                    $('#sec1').addClass('hidden');
                    $('#sec3').removeClass('hidden');
                    $('#line1').attr('src', '{{ asset('assets/img/linea-gris.png') }}');
                    $('#line2').attr('src', '{{ asset('assets/img/linea-gris.png') }}');
                    $('#line3').attr('src', '{{ asset('assets/img/linea.png') }}');
                }

                if (page == 1) {
                    $('#sec2').addClass('hidden');
                    $('#sec1').removeClass('hidden');
                    $('#line1').attr('src', '{{ asset('assets/img/linea-gris.png') }}');
                    $('#line2').attr('src', '{{ asset('assets/img/linea.png') }}');
                    $('#line3').attr('src', '{{ asset('assets/img/linea-gris.png') }}');
                    page = 2;
                }
            });

        });
    </script>

@stop
