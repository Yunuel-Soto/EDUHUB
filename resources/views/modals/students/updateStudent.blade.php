<div id="updateStudent-{{ $student->id }}" class="modal fade updateTeacher #myModal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('updateStudent', [$student->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Editar Alumno</h3>
                    <div class="content_input">
                        <input type="text" class="studentNumber" name="enrollment" placeholder=""
                            value="{{ $student->user->enrollment }}" required>
                        <label for="">Clave o matricula</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="firstName" id="" placeholder=""
                            value="{{ $student->firstName }}" required>
                        <label for="">Nombre(s)</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="lastName" id="" placeholder=""
                            value="{{ $student->lastName }}" required>
                        <label for="">Apellido(s)</label>
                    </div>
                    <div class="content_input">
                        <input type="date" name="startDate" id="" placeholder=""
                            value="{{ $student->startDate }}" required>
                        <label for="">Fecha de inicio</label>
                    </div>
                    <div class="content_input">
                        <input type="date" name="endDate" id="" placeholder=""
                            value="{{ $student->endDate }}" required>
                        <label for="">Fecha de cierre</label>
                    </div>
                    <div class="content_input">
                        <select name="currentQuarter" id="" placeholder required>
                            <option value="{{ $student->currentQuarter }}">{{ $student->currentQuarter }}</option>
                            @for ($i = 1; $i < 14; $i++)
                                @php($text = $i . '° cuatrimestre/semestre')
                                @if ($text != $student->currentQuarter)
                                    <option value="{{ $i }}° cuatrimestre/semestre">{{ $i }}°
                                        cuatrimestre/semestre
                                    </option>
                                @endif
                            @endfor
                        </select>
                        <label for="">Cuatrimestre o semestre actual</label>
                    </div>
                    <div class="content_input">
                        <select name="group" id="" placeholder required>
                            <option value="{{ $student->group->id }}">{{ $student->group->name }}</option>
                            @foreach ($groups as $group)
                                @if ($group->id != $student->group->id)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="">Asignar grupo</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="NSS" id="" placeholder="" value="{{ $student->NSS }}"
                            required>
                        <label for="">NSS</label>
                    </div>
                    <div class="content_input">
                        <select name="status" id="" placeholder required>
                            <option value="ACTIVE">ACTIVO</option>
                            <option value="INACTIVE">INACTIVO</option>
                            <option value="GRADUATE">EGRESADO</option>
                        </select>
                    </div>
                    <div class="content_input">
                        <input class="password" type="password" name="password" id="" placeholder=""
                            value="{{ old('password') }}">
                        <label for="">Contraseña</label>
                    </div>
                    <div class="content_input">
                        <input class="password" type="password" name="password_confirmation" id=""
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
                                @if ($role == 'ROLE_USER' or $role == 'ROLE_STUDENT' or in_array($role, $roles[$student->user->id])) @checked(true) @endif>
                            <label for="">{{ $role }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                    <div class="content_btn">
                        <button type="submit" class="btn_login">Guardar cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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

        $('.btn_login').on('click', function(e) {
            $('.btn_login').text('');
            var loader = '<span class="loader"></span>';

            $('.btn_login').append(loader);

        });

        $('.studentNumber').on('keypress', function(e) {
            console.log('teclear');
            return e.charCode >= 48 && e.charCode <= 57;
        });

    });
</script>
