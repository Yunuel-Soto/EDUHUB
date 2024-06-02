<div id="updateSubject-{{ $subject->id }}" class="modal fade #myModal updateCareer" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('updateSubject', [$subject->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Actualizar materia</h3>
                    <div class="content_input">
                        <input type="text" id="nameSubject-{{ $subject->id }}"
                            name="nameSubject[{{ $subject->id }}]" placeholder="" value="{{ $subject->name }}"
                            required>
                        <label for="">Nombre de la materia</label>
                    </div>
                    <h3>Asignar a carreras</h3>
                    @foreach ($careers as $career)
                        <div class="content_box">
                            <input type="checkbox" name="check-{{ $career->id }}-{{ $subject->id }}"
                                id="checkboxRol1" value="{{ $career->id }}"
                                @foreach ($subject->relationSubCareer as $list)
                                    @if ($list->career->id == $career->id)
                                        @checked(true)
                                    @endif @endforeach>
                            <label for="">{{ $career->name }}</label>
                        </div>
                    @endforeach
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
    });
</script>
