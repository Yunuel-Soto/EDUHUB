<div id="updateCareer-{{ $career->id }}" class="modal fade #myModal updateCareer" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('updateCareer', [$career->id]) }}" id="form-{{ $career->id }}">
                @csrf
                @method('PUT')
                <div id="content-{{ $career->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal_createTeacher">
                        <h3>Registrar carrera</h3>

                        <input type="text" name="count" hidden id="count-{{ $career->id }}">

                        <div class="content_input">
                            <input type="text" id="nameCareer_{{ $career->id }}"
                                name="nameCareer[{{ $career->id }}]" placeholder="" value="{{ $career->name }}"
                                required>
                            <label for="">Nombre de la carrera</label>
                        </div>
                        @php($lastId = 0)
                        <h4>Materias</h4>
                        <ul id="content_subjects-{{ $career->id }}" class="content_subjects">
                            @php($count = 0)
                            @foreach ($career->relationSubCareer as $list)
                                @php($count++)
                                @php($lastId = $list->subject->id)
                                <li id="li-{{ $count }}-{{ $career->id }}">
                                    <div class="content_input">
                                        <input type="text" id="nameSubject_{{ $count }}_{{ $career->id }}"
                                            name="nameSubject[{{ $career->id }}][{{ $list->subject->id }}]"
                                            placeholder="" value="{{ $list->subject->name }}" required>
                                        <label for="">Materia</label>
                                    </div>
                                    <div type="button" class="content_btn cont_delete" id="cont_delete">
                                        <button class="btn_delete hidden" title="Eliminar"
                                            id="deleteSubject-{{ $count }}-{{ $career->id }}">-</button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="two-btn">
                            <div type="button" class="content_btn" id="btns">
                                <button id="addSubject-{{ $career->id }}" title="Agregar">+</button>
                            </div>
                            <div type="button" class="content_btn cont_delete" id="cont_delete">
                                <button class="btn_delete hidden" title="Eliminar"
                                    id="deleteSubject-{{ $career->id }}">-</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <div class="content_btn">
                            <button type="submit" class="btn_login">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        var $div = $('#content-{{ $career->id }}');
        $('#form-{{ $career->id }}').append($div);

        @php($i = 0)
        @foreach ($career->relationSubCareer as $list)
            @php($i++)
            $('#li-{{ $i }}-{{ $career->id }}').hover(function(e) {
                $('#deleteSubject-{{ $i }}-{{ $career->id }}').removeClass(
                    'hidden');
            }, function(e) {
                $('#deleteSubject-{{ $i }}-{{ $career->id }}').addClass('hidden');
            })

            $('#deleteSubject-{{ $i }}-{{ $career->id }}').on('click', function(e) {
                e.preventDefault();
                $('#li-{{ $i }}-{{ $career->id }}').remove();
            });
        @endforeach

        $('.btn_login').on('click', function(e) {
            $('.btn_login').text('');
            var loader = '<span class="loader"></span>';

            $('.btn_login').append(loader);

        });

        // more input
        var count = {{ $lastId }};
        var start = count;

        $('#count-{{ $career->id }}').val(count);

        $('#addSubject-{{ $career->id }}').on('click', function(e) {
            e.preventDefault();

            count++;

            $('#count-{{ $career->id }}').val(count);

            var input = `<li id="li-${count}-{{ $career->id }}">` +
                `<div class="content_input">` +
                `<input type="text" name="nameSubject[{{ $career->id }}][${count}]" id="nameSubject[${count}]" placeholder="" value="{{ old('nameSubject') }}" required>` +
                '<label for="">Materia</label>' +
                '</div>' +
                '</li>';

            var btn_delete = ' <div type="button" class="content_btn cont_delete" id="cont_delete">' +
                `<button class="btn_delete hidden" title="Eliminar" id="deleteSubject-${count}-{{ $career->id }}">` +
                '-</button>' +
                '</div>';

            $('#content_subjects-{{ $career->id }}').append(input);
            $(`#li-${count}-{{ $career->id }}`).append(btn_delete);
            $('#deleteSubject-{{ $career->id }}').removeClass('hidden');

        });

        $('#deleteSubject-{{ $career->id }}').on('click', function(e) {
            e.preventDefault();
            $(`#li-${count}-{{ $career->id }}`).remove();

            count--;

            $('#count-{{ $career->id }}').val(count);

            if (start == count) {
                $('#deleteSubject-{{ $career->id }}').addClass('hidden');

            }
        });
    });
</script>
