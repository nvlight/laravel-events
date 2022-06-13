<div class="modal fade" id="add-evento-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add evento</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <form action="/add-evento/now" method="POST" name="addEventoForm" id="eventoModal" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="0">
                        <div class="input-group">
                            <label class="w-100">
                                <b>Description</b>
                                <textarea class="w-100 form-control" name="description" placeholder="Введите описание"></textarea>
                            </label>
                        </div>
                        <div class="input-group mt-1">
                            <label class="w-100">
                                <b>Date</b>
                                <input type="text" name="date" class="w-100 form-control flatpickrEventoCreateDate" placeholder="">
                            </label>
                        </div>

                        <div class="d-flex justify-content-between mt-2 w-100">
                            <div>
                                <button class="btn btn-success" type="submit">Создать</button>
                            </div>
                            <div class="d-flex align-self-center spinMessage__wrapper eventoStore__wrapper">
                                <div class="d-flex">
                                    
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise align-self-center svg spinMessage__spinSvg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                    </svg>
                                    
                                    
                                    <span class="ml-2 message">
                                        <span class="text-success">Success!</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/cabinet/evento/_inner/modals/add_evento.blade.php ENDPATH**/ ?>