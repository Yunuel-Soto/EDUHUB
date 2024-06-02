<div id="createSubject" class="modal fade #myModal updateCareer" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('createSubject') }}">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Registrar materia</h3>
                    <div class="content_input">
                        <input type="text" id="nameSubject" name="nameSubject" placeholder=""
                            value="{{ old('nameSubject') }}" required>
                        <label for="">Nombre de la materia</label>
                    </div>
                    <h3>Asignar a carreras</h3>
                    @foreach ($careers as $career)
                        <div class="content_box">
                            <input type="checkbox" name="{{ $career->id }}" id="checkboxRol1"
                                value="{{ $career->id }}">
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
