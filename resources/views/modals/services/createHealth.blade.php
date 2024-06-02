<div id="createHealth" class="modal fade #myModal updateCareer" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('createHealth') }}">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Registrar contacto</h3>
                    <div class="content_input" id="typeContact">
                        <select name="typeContact" id="">
                            <option value="Doctor(a)" selected="selected">Doctor(a)</option>
                            <option value="Doctor(a) particular">Doctor(a) particular</option>
                            <option value="Psicologo(a)">Psicologo(a)</option>
                            <option value="Psicologo(a) particular">Psicologo(a) particular</option>
                            <option value="Asesor(a)">Asesor(a)</option>
                            <option value="Dermatologo(a)">Dermatologo(a)</option>
                            <option value="Terapeuta">Terapeuta</option>
                            <option value="Ginecologo(a)">Ginecologo(a)</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <label for="">Tipo de contacto</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="name" placeholder="" value="{{ old('name') }}" required>
                        <label for="">Nombre del contacto</label>
                    </div>
                    <div class="content_input">
                        <input type="text" id="" name="address" placeholder="" value="{{ old('address') }}"
                            required>
                        <label for="">Direccion</label>
                    </div>
                    <div class="content_input">
                        <input type="text" id="phoneNumber" name="phoneNumber" placeholder=""
                            value="{{ old('phoneNumber') }}" required>
                        <label for="">Numero de contacto</label>
                    </div>
                    <div class="content_input">
                        <input type="text" id="cost" name="cost" placeholder="" value="{{ old('cost') }}"
                            required>
                        <label for="">Costo de consulta</label>
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

        $('#cost').on('keypress', function(e) {
            console.log('teclear');
            return e.charCode >= 48 && e.charCode <= 57;
        });
        $('#phoneNumber').on('keypress', function(e) {
            console.log('teclear');
            return e.charCode >= 48 && e.charCode <= 57;
        });

        $('#typeContact').on('change', function(e) {
            console.log($('#typeContact option:selected').text());
            if ($('#typeContact option:selected').text() == "Otro") {
                var input = '<div class="content_input" id="inputType">' +
                    '<input type = "text" id = "" name = "typeContactOther" placeholder = "" value = "{{ old('address') }}" required >' +
                    '<label for = "" >Describe el tipo de contacto</label>' +
                    '</div>';
                $('#typeContact').after(input);
            } else {
                $('#inputType').remove();
            }
        });
    });
</script>
