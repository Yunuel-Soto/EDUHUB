<div class="modal fade" id="deleteStudent-{{ $student->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('deleteStudent', [$student->id]) }}" method="POST">
                @csrf
                @method('delete')
                <div class="modal-header" id="modal_delete">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <img src="{{ asset('assets/img/advertencia.png') }}" alt="imagen de advertencia" />
                        Eliminar usuario
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estas seguro de dar de baja el usuario {{ $student->firstName }}
                    {{ $student->lastName }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
