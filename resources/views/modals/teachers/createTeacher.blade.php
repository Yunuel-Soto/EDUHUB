<div id="createTeacher" class="modal fade #myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('registerTeacher') }}">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Registrar nuevo Profesor</h3>
                    <div class="content_input">
                        <input type="text" id="studentNumber" name="enrollment" placeholder=""
                            value="{{ old('enrollment') }}">
                        <label for="">Clave o matricula</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="firstName" id="firstName" placeholder=""
                            value="{{ old('firstName') }}">
                        <label for="">Nombre(s)</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="lastName" id="lastName" placeholder=""
                            value="{{ old('lastName') }}">
                        <label for="">Apellido(s)</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="career" id="career" placeholder="" value="{{ old('career') }}">
                        <label for="">Carrera</label>
                    </div>
                    <div class="content_input">
                        <input type="date" name="startDate" id="startDate" placeholder=""
                            value="{{ old('career') }}">
                        <label for="">Fecha de inicio</label>
                    </div>
                    <div class="content_input">
                        <input class="password" type="password" name="password" id="password" placeholder=""
                            value="{{ old('password') }}">
                        <label for="">Contraseña</label>
                    </div>
                    <div class="content_input">
                        <input class="password" type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="" value="{{ old('password_confirmation') }}">
                        <label for="">Repetir contraseña</label>
                    </div>
                    <div class="content_box">
                        <input type="checkbox" name="pass" id="checkbox">
                        <label for="">Mostrar contraseñas</label>
                    </div>
                    <h4 for="">Asiganr roles</h4>
                    @foreach (Auth::user()->ROLES() as $role)
                        <div class="content_box">
                            <input type="checkbox" name="{{ $role }}" id="checkboxRol1"
                                @if ($role == 'ROLE_USER' or $role == 'ROLE_TEACHER') @checked(true) @endif>
                            <label for="">{{ $role }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                    <div class="content_btn">
                        <button type="submit" id="btn_login">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if (session()->has('password_incorrect'))
    @include('modals/generalAlerts/alertError', ['msg' => 'password_incorrect'])
@endif
@if (session()->has('identifyNumber_not_found'))
    @include('modals/generalAlerts/alertError', ['msg' => 'identifyNumber_not_found'])
@endif
@if (session()->has('identifyNumber_used'))
    @include('modals/generalAlerts/alertError', ['msg' => 'identifyNumber_used'])
@endif

@if (session()->has('saved_success'))
    @include('modals/generalAlerts/alertSuccess', [
        'title' => 'Accion exitosa',
        'text' => 'El usuario ha sido agregado con exito',
    ])
@endif

<script>
    $(document).ready(function() {
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

        @if (session()->has('password_incorrect') ||
                session()->has('identifyNumber_not_found') ||
                session()->has('identifyNumber_used'))
            $('#alertError').modal(true);
        @endif

        @if (session()->has('saved_success'))
            $('#alertSuccess').modal(true);
        @endif

        // Input errors

        @if ($errors->first('enrollment'))
            $('#studentNumber').addClass('error');
        @endif

        @if ($errors->first('firstName'))
            $('#firstName').addClass('error');
        @endif

        @if ($errors->first('lastName'))
            $('#lastName').addClass('error');
        @endif

        @if ($errors->first('career'))
            $('#career').addClass('error');
        @endif

        @if ($errors->first('startDate'))
            $('#startDate').addClass('error');
        @endif

        @if ($errors->first('password_confirmation'))
            $('#password_confirmation').addClass('error');
        @endif
        @if ($errors->first('password'))
            $('#password').addClass('error');
        @endif

        $('#studentNumber').on('keyup', function(e) {
            $('#studentNumber').removeClass('error');
        });

        $('#firstName').on('keyup', function(e) {
            $('#firstName').removeClass('error');
        });

        $('#lastName').on('keyup', function(e) {
            $('#lastName').removeClass('error');
        });

        $('#career').on('keyup', function(e) {
            $('#career').removeClass('error');
        });

        $('#startDate').on('keyup', function(e) {
            $('#startDate').removeClass('error');
        });

        $('#password_confirmation').on('keyup', function(e) {
            $('#password_confirmation').removeClass('error');
        });

        $('#password').on('keyup', function(e) {
            $('#password').removeClass('error');
        });
    });
</script>
