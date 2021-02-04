<div class="modal fade" id="add-tag-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Evento Tag && Add Standalone Tag</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="accordion" id="accordionEventoTag">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button btn-sm" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                                Add Evento Tag
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse show" aria-labelledby="heading3" data-parent="#accordionEventoTag">
                            <div class="accordion-body">
                                <form action="{{ route('cabinet.evento.eventotag.store_ajax') }}" method="POST" name="addEventoTagForm">
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <label class="mr-3" for="addEventoTagModalId">Choose need tag</label>
                                            <select id="addEventoTagModalId" name="tags" class="form-select">
                                            </select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <label class="mr-3" for="addEventoTagValueModalId">Tag Value</label>
                                            <input id="addEventoTagValueModalId" type="text" name="value" class="form-control">
                                        </div>
                                        <div class="input-group mb-3">
                                            <label class="mr-3" for="addEventoTagCaptionModalId">Tag Caption</label>
                                            <input id="addEventoTagCaptionModalId" type="text" name="caption" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        @csrf
                                        <input type="hidden" name="evento_id" value="0">
                                        <input type="hidden" name="tag_id" value="0">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">add tag for Evento</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                Tag CRUD
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-parent="#accordionEventoTag">
                            <div class="accordion-body">
                                <form action="{{ route('cabinet.evento.eventotag.store_ajax') }}" method="POST" name="addStandaloneTagForm">
                                    @csrf
                                    <input type="hidden" name="tag_id" value="0">
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="addTagModalId">Tag name</span>
                                            <input class="form-control" type="text" name="name" value="" placeholder="type tag">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text" id="addTagModalId">Tag color</span>
                                            <input class="form-control" type="text" name="color" value="" placeholder="type tag color">
                                        </div>
                                        <p class="message-text resultMessage d-none">Добавлено!</p>
                                    </div>
                                    <div style="display: flex;justify-content: flex-end;">
                                        <button type="button" class="btn btn-secondary" style="margin-right: 0.3em;" data-dismiss="modal">Close</button>
                                        <button id="addStandAloneTagBtnId" type="submit" class="btn btn-primary">add tag</button>
                                    </div>
                                    <div class="crud_tags">

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>