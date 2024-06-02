<div class="modal fade #alertError" id="alertError" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" id="modal_header_error">
                <h5 class="modal-title" id="">
                    <img src="{{ asset('assets/img/advertencia.png') }}" alt="">
                    Error la sesion fallo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body_error">
                @if ($msg == 'password_incorrect')
                    La sesion fallo debido a que las contraseñas no coinciden.
                @endif
                @if ($msg == 'identifyNumber_not_found')
                    La sesion fallo debido a que la clave o matricula no se encontro.
                @endif
                @if ($msg == 'identifyNumber_used')
                    La sesion fallo debido a que la clave o matricula ya se esta usando.
                @endif
                @if ($msg == 'session_faild')
                    La sesion fallo debido a que las credenciales son incorrectas
                @endif
            </div>
            <div class="modal-footer" id="footer_error">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
