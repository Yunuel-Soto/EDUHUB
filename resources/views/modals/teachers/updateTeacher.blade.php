<div id="updateTeacher-{{ $teacher->id }}" class="modal fade updateTeacher" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('updateTeacher', [$teacher->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Actualizar datos</h3>
                    <div class="content_input">
                        <input type="text" id="studentNumber-{{ $teacher->id }}" name="enrollment" placeholder=""
                            value="{{ $teacher->user->enrollment }}" required>
                        <label for="">Clave o matricula</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="firstName" id="firstName-{{ $teacher->id }}" placeholder=""
                            value="{{ $teacher->firstName }}" required>
                        <label for="">Nombre(s)</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="lastName" id="lastName-{{ $teacher->id }}" placeholder=""
                            value="{{ $teacher->lastName }}" required>
                        <label for="">Apellido(s)</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="career" id="career-{{ $teacher->id }}" placeholder=""
                            value="{{ $teacher->career }}" required>
                        <label for="">Carrera</label>
                    </div>
                    <div class="content_input">
                        <input type="date" name="startDate" id="startDate-{{ $teacher->id }}" placeholder=""
                            value="{{ $teacher->startDate }}" required>
                        <label for="">Fecha de inicio</label>
                    </div>
                    <div class="content_input">
                        <input type="date" name="endDate" id="endDate-{{ $teacher->id }}" placeholder=""
                            value="{{ $teacher->endDate }}">
                        <label for="">Fecha de termino</label>
                    </div>
                    <div class="content_input">
                        <input class="password" type="password" name="password" id="password-{{ $teacher->id }}"
                            placeholder="" value="{{ old('password') }}">
                        <label for="">Contraseña</label>
                    </div>
                    <div class="content_input">
                        <input class="password" type="password" name="password_confirmation-{{ $teacher->id }}"
                            id="password_confirmation" placeholder="" value="{{ old('password_confirmation') }}">
                        <label for="">Repetir contraseña</label>
                    </div>
                    <div class="content_box">
                        <input type="checkbox" name="pass" id="checkbox-{{ $teacher->id }}">
                        <label for="">Mostrar contraseñas</label>
                    </div>
                    <h4 for="">Asiganr roles</h4>
                    @php($band = false)

                    @foreach (Auth::user()->ROLES() as $role)
                        <div class="content_box">
                            <input type="checkbox" name="{{ $role }}-{{ $teacher->id }}"
                                id="{{ $role }}-{{ $teacher->id }}"
                                @if (in_array($role, $roles[$teacher->user->id])) @checked(true) @endif>
                            <label for="">{{ $role }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                    <div class="content_btn">
                        <button type="submit" id="btn_login-{{ $teacher->id }}">Guardar cambios</button>
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
    @include('modals/generalalerts/alertError', ['msg' => 'identifyNumber_not_found'])
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
        $('#checkbox-{{ $teacher->id }}').on('click', function(e) {
            if (band) {
                $('.password').attr('type', 'text');
                console.log($('#checkbox-{{ $teacher->id }}').val())
                band = false;
            } else {
                $('.password').attr('type', 'password');
                band = true;
            }
            console.log('click')
        });

        $('#btn_login-{{ $teacher->id }}').on('click', function(e) {
            $('#btn_login-{{ $teacher->id }}').text('');
            var loader = '<span class="loader"></span>';

            $('#btn_login-{{ $teacher->id }}').append(loader);

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

    });
</script>
