<div class="modal fade" id="add-category-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add Evento Category && CRUD for Category</h6>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="accordion" id="accordionEventoCategory">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button btn-sm" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Add Evento Category
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-parent="#accordionEventoCategory">
                            <div class="accordion-body">
                                <form action="{{ route('cabinet.evento.eventocategory.store_ajax') }}" method="POST" name="addCategoryForm">
                                    <div class="modal-body">
                                        <label for="addEventoCategoryModalId">Choose need category</label>
                                        <select id="addEventoCategoryModalId" name="categories" class="form-select">
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        @csrf
                                        <input type="hidden" name="evento_id" value="0">
                                        <input type="hidden" name="category_id" value="0">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">add category for Evento</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Category CRUD
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-parent="#accordionEventoCategory">
                            <div class="accordion-body">
                                <form action="{{ route('cabinet.evento.category.store_ajax') }}" method="POST" name="addStandaloneCategoryForm">
                                    @csrf
                                    <input type="hidden" name="category_id" value="0">
                                    <div class="modal-body">
                                        <label for="addCategoryModalId">New Category</label>
                                        <input class="form-control" id="addCategoryModalId" type="text" name="name" value="" placeholder="type category name">
                                        <p class="message-text resultMessage d-none">Добавлено!</p>
                                    </div>
                                    <div class="" style="display: flex;justify-content: flex-end;">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right: 0.3em;">Close</button>
                                        <button id="addStandAloneCategoryBtnId" type="submit" class="btn btn-primary">add category</button>
                                    </div>
                                    <div class="crud_categories" style="max-height: 300px; overflow-y: auto;">

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