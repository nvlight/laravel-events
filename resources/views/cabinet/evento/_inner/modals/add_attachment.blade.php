<div class="modal fade" id="add-attachment-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add attachment for evento</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <form action="/save-attachment/now" method="POST" name="addAttachmentForm" enctype="multipart/form-data">
                        <input type="hidden" name="evento_id" value="0">
                        <input type="hidden" name="_token" value="0">
                        <div class="input-group">
                            <label class="w-100">
                                <span class="w-100">Выбор файла</span>
                                <input type="file" name="file" class="w-100">
                            </label>
                        </div>
                        <div class="w-100">
                            <button type="submit" class="btn btn-primary mt-5">Прикрепить файл</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>