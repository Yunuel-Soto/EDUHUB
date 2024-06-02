<div id="createGroup" class="modal fade #myModal updateCareer" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('createGroup') }}">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Registrar Grupo</h3>
                    <div class="content_input">
                        <input type="text" id="nameGroup" name="nameGroup" placeholder=""
                            value="{{ old('nameGroup') }}" required>
                        <label for="">Nombre de la materia</label>
                    </div>
                    <div class="content_input">
                        <input type="text" id="quota" name="quota" placeholder="" value="{{ old('quota') }}"
                            required>
                        <label for="">Cuota de la materia</label>
                    </div>
                    <div class="content_input">
                        <input type="text" id="duration" name="duration" placeholder=""
                            value="{{ old('duration') }}" required>
                        <label for="">Duracion de la materia</label>
                    </div>
                    <h3>Asignar a carrera</h3>
                    <div class="content_input">
                        <select name="career" id="" placeholder>
                            @foreach ($careers as $career)
                                <option value="{{ $career->id }}">{{ $career->name }}</option>
                            @endforeach
                        </select>
                        <label for="">Selecciona la carrera</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <div class="content_btn">
                        <button type="submit" class="btn_login">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.btn_login').on('click', function(e) {
            $('.btn_login').text('');
            var loader = '<span class="loader"></span>';

            $('.btn_login').append(loader);
        });

        $('#quota').on('keypress', function(e) {
            console.log('teclear');
            return e.charCode >= 48 && e.charCode <= 57;
        });
    });
</script>
