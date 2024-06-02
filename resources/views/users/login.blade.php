@extends('layouts/baseLogin')

@section('title', 'Login')

@section('content')

    <main class="main_login">
        <form action="{{ route('login') }}" method="POST" class="form_login animate_form_preHome">
            @csrf
            <div>
                <h1 class="animate_eduhub">EDU <label class="label_color">HUB</label></h1>
            </div>
            <div class="content_input">
                <input type="text" name="enrollment" id="studentNumber" value="{{ old('enrollment') }}" required
                    placeholder>
                <label for="">{{ trans('eduhub.login.keyOrEnroll') }}</label>
            </div>
            <div class="content_input">
                <input type="password" name="password" id="password" value="{{ old('password') }}" required placeholder>
                <label for="">{{ trans('eduhub.login.password') }}</label>
            </div>
            <div class="content_box">
                <input type="checkbox" name="pass" id="checkbox">
                <label for="">{{ trans_choice('eduhub.login.showPass', 0) }}</label>
            </div>
            <div class="content_btn">
                <button id="btn_login">{{ trans('eduhub.login.start_session') }}</button>
            </div>
            <p>{{ trans('eduhub.login.question_session') }}, <a
                    href="{{ route('shSing') }}">{{ trans_choice('eduhub.login.register', 0) }}</a></p>
        </form>
        <picture class="animate_logo">
            <img src="{{ asset('assets/img/EDUHUB-02.png') }}" alt="logo_eduhub.png">
        </picture>
    </main>

    @if (session()->has('session_faild'))
        @include('modals/generalAlerts/alertError', ['msg' => 'session_faild'])
    @endif

    <script>
        $(document).ready(function() {
            @if (session()->has('session_faild'))
                $('#alertError').modal(true)
            @endif
            var band = true;
            $('#checkbox').on('click', function(e) {
                if (band) {
                    $('#password').attr('type', 'text');
                    console.log($('#checkbox').val())
                    band = false;
                } else {
                    $('#password').attr('type', 'password');
                    band = true;
                }
                console.log('click')
            });

            $('#btn_login').on('click', function(e) {
                $('#btn_login').text('');
                var loader = '<span class="loader"></span>';

                $('#btn_login').append(loader);

            });

            $('#studentNumber').on('keypress', function(e) {
                console.log('teclear');
                return e.charCode >= 48 && e.charCode <= 57;
            });
        });
    </script>

@stop
