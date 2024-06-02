<div id="createCareer" class="modal fade #myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('createCareer') }}">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Registrar carrera</h3>
                    <input type="text" name="count" hidden id="count">
                    <div class="content_input">
                        <input type="text" id="nameCareer" name="nameCareer" placeholder=""
                            value="{{ old('nameCareer') }}" required>
                        <label for="">Nombre de la carrera</label>
                    </div>
                    <h4>Materias</h4>
                    <ul id="content_subjects" class="content_subjects"></ul>
                    <div class="two-btn">
                        <div type="button" class="content_btn shadow" id="btns">
                            <button id="addSubject" title="Agregar">+</button>
                        </div>
                        <div type="button" class="content_btn cont_delete hidden" id="cont_delete">
                            <button class="btn_delete" title="Eliminar" id="deleteSubject">-</button>
                        </div>
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

        const ul = $('#content_subjects');
        var count = ul.val();

        $('#addSubject').on('click', function(e) {
            e.preventDefault();

            count++;
            $('#count').val(count);
            var input = `<div class="content_input" id="nameSubject${count}">` +
                `<input type="text" name="nameSubject[${count}]" id="nameSubject${count}input" placeholder="" value="{{ old('nameSubject') }}" required>` +
                '<label for="">Nombre de la materia</label>' +
                '</div>';

            if (count == 1) {
                $('#cont_delete').removeClass('hidden');
            }

            $('#content_subjects').append(input);

        });

        $('#deleteSubject').on('click', function(e) {
            e.preventDefault();
            $(`#nameSubject${count}`).remove();
            count--;
            $('#count').val(count);
        });


    });
</script>
