<div id="createStudent" class="modal fade #myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('createStudent') }}">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Registrar nuevo Alumno</h3>
                    <div class="content_input">
                        <input type="text" class="studentNumber" name="enrollment" placeholder=""
                            value="{{ old('enrollment') }}" required>
                        <label for="">Clave o matricula</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="firstName" id="firstName" placeholder=""
                            value="{{ old('firstName') }}" required>
                        <label for="">Nombre(s)</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="lastName" id="lastName" placeholder=""
                            value="{{ old('lastName') }}" required>
                        <label for="">Apellido(s)</label>
                    </div>
                    <div class="content_input">
                        <input type="date" name="startDate" id="startDate" placeholder=""
                            value="{{ old('startDate') }}" required>
                        <label for="">Fecha de inicio</label>
                    </div>
                    <div class="content_input">
                        <input type="date" name="endDate" id="startDate" placeholder="" value="{{ old('endDate') }}"
                            required>
                        <label for="">Fecha de cierre</label>
                    </div>
                    <div class="content_input">
                        <select name="currentQuarter" id="currentQuarter" placeholder required>
                            @for ($i = 1; $i < 14; $i++)
                                <option value="{{ $i }}° cuatrimestre/semestre">{{ $i }}°
                                    cuatrimestre/semestre
                                </option>
                            @endfor
                        </select>
                        <label for="">Cuatrimestre o semestre actual</label>
                    </div>
                    <div class="content_input">
                        <select name="group" id="" placeholder required>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        <label for="">Asignar grupo</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="NSS" id="NSS" placeholder="" value="{{ old('NSS') }}"
                            required>
                        <label for="">NSS</label>
                    </div>
                    <div class="content_input">
                        <input class="password" type="password" name="password" id="password" placeholder=""
                            value="{{ old('password') }}" required>
                        <label for="">Contraseña</label>
                    </div>
                    <div class="content_input">
                        <input class="password" type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="" value="{{ old('password_confirmation') }}" required>
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
                                @if ($role == 'ROLE_USER' or $role == 'ROLE_STUDENT') @checked(true) @endif>
                            <label for="">{{ $role }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                    <div class="content_btn">
                        <button type="submit" id="btn_student">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if (session()->has('save_user'))
    @include('modals/generalAlerts/alertSuccess', [
        'title' => 'Accion exitosa',
        'text' => 'El usuario ha sido agregado con exito',
    ])
@endif

@if (session()->has('error_enrollment'))
    @include('modals/generalAlerts/alertError2', [
        'title' => 'Error al guardar usuario',
        'text' => 'La clave o matricula ya esta registrada, intente con otra',
    ])
@endif

@if (session()->has('error_password'))
    @include('modals/generalAlerts/alertError2', [
        'title' => 'Error al guardar usuario',
        'text' => 'Las contraseñas no coincidieron, verifique sus credenciales antes de registrar el usuario',
    ])
@endif

<script>
    $(document).ready(function() {
        // Alerts
        @if (session()->has('error_enrollment'))
            $('#alertError2').modal(true);
        @endif

        @if (session()->has('error_password'))
            $('#alertError2').modal(true);
        @endif

        @if (session()->has('save_user'))
            $('#alertSuccess').modal(true);
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

        $('#btn_student').on('click', function(e) {
            $('#btn_student').text('');
            var loader = '<span class="loader"></span>';

            $('#btn_student').append(loader);

        });

        $('.studentNumber').on('keypress', function(e) {
            console.log('teclear');
            return e.charCode >= 48 && e.charCode <= 57;
        });
    });
</script>
