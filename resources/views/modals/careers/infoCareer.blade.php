<div id="infoCareer-{{ $career->id }}" class="modal fade #myModal infoCareer" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_createTeacher">
                <h3>Plan curricular de la carrera de {{ $career->name }}</h3>
                <div class="content_careers">
                    <section>
                        <h4><label class="label_color">Materias</label></h4>
                        <ul>
                            @foreach ($career->relationSubCareer as $list)
                                <li>{{ $list->subject->name }}</li>
                            @endforeach
                        </ul>
                    </section>
                    <section>
                        <h4><label class="label_color">Fecha de creacion de la carrera</label></h4>
                        <p>{{ $career->created_at }}</p>
                    </section>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
