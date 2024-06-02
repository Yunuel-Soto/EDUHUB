@extends('layouts/base')

@section('title', 'Servicios de salud')

@section('content')

    <div class="content_health">
        <h2>CONTACTOS DE <label class="label_color">SALUD</label></h2>
        <header>
            @include('modals/services/createHealth')
            <div class="content_btn">
                @if (Auth::user()->getRoles('ROLE_ADMIN') or Auth::user()->getRoles('ROLE_SUPERADMIN'))
                    <a title="Agregar Carrera" data-toggle="modal" data-target="#createHealth"><button>+ Agregar
                            contacto</button></a>
                @endif
            </div>
        </header>
        <main>
            @foreach ($healths as $health)
                @include('modals/services/deleteHealth', [$health->id])
                @include('modals/services/updateHealth', [$health->id])
                <div class="card_health animateCard">
                    <picture>
                        <img src="{{ asset('assets/img/perfil.png') }}" alt="">
                        <h3>{{ $health->typeContact }}</h3>
                    </picture>
                    <div class="info">
                        <p><strong>Nombre: </strong>{{ $health->name }}</p>
                        <p><strong>Direcciòn: </strong>{{ $health->address }}</p>
                        <p><strong>Costo: </strong>${{ $health->cost }}</p>
                        <p><strong>Numero de contacto: </strong>{{ $health->phoneNumber }}</p>
                    </div>
                    <footer>
                        @if (Auth::user()->getRoles('ROLE_SUPERADMIN') or Auth::user()->getRoles('ROLE_ADMIN'))
                            <a title="Eliminar" data-toggle="modal" data-target="#deleteHealth-{{ $health->id }}">
                                <button class="delete">Eliminar</button>
                            </a>
                            <a title="Editar" data-toggle="modal" data-target="#updateHealth-{{ $health->id }}">
                                <button class="update">Editar</button>
                            </a>
                        @endif
                    </footer>
                </div>
            @endforeach
        </main>
    </div>

    @if (session()->has('delete_success'))
        @include('modals/generalAlerts/alertSuccess', [
            'title' => 'Contacto eliminado',
            'text' => 'Contacto de salud eliminado con exito',
        ])
    @endif

    <script>
        @if (session()->has('delete_success'))
            $('#alertSuccess').modal(true);
        @endif

        $(document).ready(function() {

            let lastScroll = $(window).scrollTop();

            $(window).scroll(function() {
                const currentScroll = $(window).scrollTop();
                console.log(`last: ${lastScroll}`);
                console.log(`currentScroll: ${currentScroll}`);

                if (currentScroll > lastScroll) {
                    $('#nav1').removeClass('navScroll');
                    $('#nav1').removeClass('sinNav');
                } else {
                    $('#nav1').addClass('navScroll');
                    $('.card_health').removeClass('animateCard');
                }

                if (currentScroll == 0) {
                    $('#nav1').removeClass('navScroll');
                    $('#nav1').addClass('sinNav');
                }

                lastScroll = currentScroll <= 0 ? 0 : currentScroll;

            });
        });
    </script>

@stop
