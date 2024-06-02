<div id="scheduleUpdate" class="modal fade #myModal updateCareer" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('editSchedule') }}">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_createTeacher">
                    <h3>Editar horario del profesor</h3>
                    <div class="content_input">
                        <select name="teacherSchedule" id="selectTeacher">
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->user->id }}">{{ $teacher->lastName }}
                                    {{ $teacher->firstName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <div class="content_btn">
                        <button type="submit" class="btn_login">Ir</button>
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
