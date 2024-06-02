@extends('layouts/base')

@section('title', '¡Bienvenido ' . Auth::user()->teacher->firstName . '!')

@section('content')
    <main class="content_main">

        <section>
            <div class="animation_text">
                <h2>A TU ALCANCE</h2>
                <h1>INFORMACION ACADEMICA</h1>
                <p>
                    Una aplicación que te ofrece la facilita la administración escolar tanto para el alumno como para el
                    docente todo en una sola aplicación.
                </p>
            </div>
            <div class="animation_img">
                <picture>
                    <img src="{{ asset('assets/img/EDUHUB_sin.png') }}" alt="">
                </picture>
            </div>
        </section>
    </main>

    <script>
        $(document).ready(function() {
            $('#nav1').addClass('animate_nav');
        });
    </script>

@stop
