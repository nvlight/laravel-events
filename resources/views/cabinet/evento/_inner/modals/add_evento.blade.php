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
                        <div class="w-100">
                            <button type="submit" class="btn btn-primary mt-2">Создать</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>