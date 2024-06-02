@extends('layouts/baseLogin')

@section('title', 'Login')

@section('content')

    <main class="main_login">
        <form action="{{ route('singIn') }}" method="POST" class="form_login animate_form_preHome">
            @csrf
            <div>
                <h1 class="animate_eduhub">EDU <label class="label_color">HUB</label></h1>
            </div>
            <div class="content_input">
                <input type="text" id="studentNumber" name="enrollment" placeholder="" required
                    value="{{ old('enrollment') }}">
                <label for="">{{ trans('eduhub.login.keyOrEnroll') }}</label>
            </div>
            <div class="content_input">
                <input type="text" name="firstName" placeholder="" required value="{{ old('firstName') }}">
                <label for="">{{ trans('eduhub.login.firstName') }}</label>
            </div>
            <div class="content_input">
                <input type="text" name="lastName" placeholder="" required value="{{ old('lastName') }}">
                <label for="">{{ trans('eduhub.login.lastName') }}</label>
            </div>
            <div class="content_input">
                <input type="text" name="career" placeholder="" required value="{{ old('career') }}">
                <label for="">{{ trans('eduhub.login.career') }}</label>
            </div>
            <div class="content_input">
                <input class="password" type="password" name="password" required placeholder=""
                    value="{{ old('password') }}">
                <label for="">{{ trans('eduhub.login.password') }}</label>
            </div>
            <div class="content_input">
                <input class="password" type="password" name="password_confirmation" required placeholder=""
                    value="{{ old('password_confirmation') }}">
                <label for="">{{ trans('eduhub.login.password_confirmation') }}</label>
            </div>
            <div class="content_box">
                <input type="checkbox" name="pass" id="checkbox">
                <label for="">{{ trans_choice('eduhub.login.showPass', 1) }}</label>
            </div>
            <div class="content_btn">
                <button id="btn_login">{{ trans_choice('eduhub.login.register', 1) }}</button>
            </div>
            <p>{{ trans('eduhub.login.ifSession') }} <a
                    href="{{ route('shLogin') }}">{{ trans('eduhub.login.start_session') }}</a>
            </p>

        </form>
        <picture class="animate_logo">
            <img src="{{ asset('assets/img/EDUHUB-02.png') }}" alt="logo_eduhub.png">
        </picture>
    </main>

    @if (session()->has('password_incorrect'))
        @include('modals/generalAlerts/alertError', ['msg' => 'password_incorrect'])
    @endif
    @if (session()->has('identifyNumber_not_found'))
        @include('modals/generalAlerts/alertError', ['msg' => 'identifyNumber_not_found'])
    @endif
    @if (session()->has('identifyNumber_used'))
        @include('modals/generalAlerts/alertError', ['msg' => 'identifyNumber_used'])
    @endif

    <script>
        $(document).ready(function() {
            @if (session()->has('password_incorrect') ||
                    session()->has('identifyNumber_not_found') ||
                    session()->has('identifyNumber_used'))
                $('#alertError').modal(true)
            @endif

            var band = true;
            $('#checkbox').on('click', function(e) {
                if (band) {
                    $('.password').attr('type', 'text');
                    console.log($('#checkbox').val())
                    band = false;
                } else {
                    $('.password').attr('type', 'password');
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
