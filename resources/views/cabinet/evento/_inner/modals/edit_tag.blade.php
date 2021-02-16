<div class="modal fade" id="edit-tag-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit tag</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <form action="/add-tag/now" method="POST" name="editTagForm" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="0">
                        <div class="input-group">
                            <label class="w-100">
                                <b>Tag</b>
                                <input class="w-100 form-control" name="name" placeholder="tag">
                            </label>
                        </div>
                        <div class="input-group">
                            <label class="w-100">
                                <b>Color</b>
                                <input class="w-100 form-control" name="color" placeholder="color">
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-primary mt-2">Редактировать</button>
                            </div>

                            <div class="d-flex align-self-center tagEdit__reportWrapper">
                                <div class="d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise align-self-center tagEdit__successEditSpin d-none" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                    </svg>
                                    <span class="ml-2 tagEdit__resultButtonsMessages d-none">
                                    </span>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>