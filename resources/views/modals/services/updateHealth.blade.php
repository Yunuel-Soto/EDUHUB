<div id="updateHealth-{{ $health->id }}" class="modal fade #myModal updateCareer" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('updateHealth', [$health->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Registrar contacto</h3>
                    <div class="content_input" id="healthType-{{ $health->id }}">
                        @php($band = false)
                        <select name="healthType" id="">
                            <option value="Doctor(a)"
                                @if ($health->typeContact == 'Doctor(a)') selected="selected" @php($band = true) @endif>
                                Doctor(a)
                            </option>
                            <option value="Doctor(a) particular"
                                @if ($health->typeContact == 'Doctor(a) particular') selected="selected" @php($band = true) @endif>
                                Doctor(a) particular
                            </option>
                            <option value="Psicologo(a)"
                                @if ($health->typeContact == 'Psicologo(a)') selected="selected" @php($band = true) @endif>
                                Psicologo(a)</option>
                            <option value="Psicologo(a) particular"
                                @if ($health->typeContact == 'Psicologo(a) particular') selected="selected" @php($band = true) @endif>
                                Psicologo(a) particular
                            </option>
                            <option value="Asesor(a)"
                                @if ($health->typeContact == 'Asesor(a)') selected="selected" @php($band = true) @endif>
                                Asesor(a)</option>
                            <option value="Dermatologo(a)"
                                @if ($health->typeContact == 'Dermatologo(a)') selected="selected" @php($band = true) @endif>
                                Dermatologo(a)</option>
                            <option value="Terapeuta"
                                @if ($health->typeContact == 'Terapeuta') selected="selected" @php($band = true) @endif>
                                Terapeuta</option>
                            <option value="Ginecologo(a)"
                                @if ($health->typeContact == 'Ginecologo(a)') selected="selected" @php($band = true) @endif>
                                Ginecologo(a)</option>
                            @if ($band == false)
                                <option value="Otro" selected="selected">Otro</option>
                            @else
                                <option value="Otro">Otro</option>
                            @endif
                        </select>
                        <label for="">Tipo de contacto</label>
                    </div>
                    <div class="content_input">
                        <input type="text" name="name" placeholder="" value="{{ $health->name }}" required>
                        <label for="">Nombre del contacto</label>
                    </div>
                    <div class="content_input">
                        <input type="text" id="" name="address" placeholder=""
                            value="{{ $health->address }}" required>
                        <label for="">Direccion</label>
                    </div>
                    <div class="content_input">
                        <input type="text" id="phoneNumber-{{ $health->id }}" name="phoneNumber" placeholder=""
                            value="{{ $health->phoneNumber }}" required>
                        <label for="">Numero de contacto</label>
                    </div>
                    <div class="content_input">
                        <input type="text" id="cost-{{ $health->id }}" name="cost" placeholder=""
                            value="{{ $health->cost }}" required>
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

        $('#cost-{{ $health->id }}').on('keypress', function(e) {
            console.log('teclear');
            return e.charCode >= 48 && e.charCode <= 57;
        });
        $('#phoneNumber-{{ $health->id }}').on('keypress', function(e) {
            console.log('teclear');
            return e.charCode >= 48 && e.charCode <= 57;
        });

        $('#healthType-{{ $health->id }}').on('change', function(e) {
            var option = $('#healthType-{{ $health->id }} option:selected').text();

            console.log(option);

            if (option == "Otro") {
                var input = '<div class="content_input" id="inputType-{{ $health->id }}">' +
                    '<input type = "text" id = "" name = "typeContactOther" placeholder = "" value = "{{ $health->typeContact }}" required >' +
                    '<label for = "" >Describe el tipo de contacto</label>' +
                    '</div>';
                $('#healthType-{{ $health->id }}').after(input);
            } else {
                $('#inputType-{{ $health->id }}').remove();
            }
        });

        @if ($band == false)
            var input = '<div class="content_input" id="inputType-{{ $health->id }}">' +
                '<input type = "text" id = "" name = "typeContactOther" placeholder = "" value = "{{ $health->typeContact }}" required >' +
                '<label for = "" >Describe el tipo de contacto</label>' +
                '</div>';
            $('#healthType-{{ $health->id }}').after(input);
        @endif
    });
</script>
