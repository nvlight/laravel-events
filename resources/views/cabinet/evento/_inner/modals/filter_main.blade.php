<div class="modal fade" id="tagvalue-main-filter" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tag values - main filter</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('cabinet.evento.eventotagcounting.get_month_gistogramm_by_year_ajax') }}"
                      name="tagValueMainFilterForm" class="d-inline-flex spinMessage__wrapper tagValueMainFilter__wrapper">

                    <div class="d-flex flex-column">

                        <div class="form-group">
                            <label class="w-100">
                                <span>categories</span>
                                <select name="category_ids" class="form-control w-100" multiple>
                                    <option value="0">select</option>
                                </select>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="w-100">
                                <span>tags</span>
                                <select name="tag_ids" class="form-control w-100" multiple>
                                    <option value="0">select</option>
                                </select>
                            </label>
                        </div>

                        <div class="d-flex flex-row">
                            <label>
                                <span>date start:</span>
                                <input type="text" name="date1" class="form-control mainFilterStartDate" value="">
                            </label>

                            <label class="ml-2">
                                <span>date end:</span>
                                <input type="text" name="date2" class="form-control mainFilterEndDate" value="">
                            </label>
                        </div>

                        <div class="d-flex flex-row">
                            <label>
                                <span>Сумма начальная</span>
                                <input class="form-control " id="amount1" name="amount1" placeholder="0" value="0">
                            </label>

                            <label class="ml-2">
                                <span>Сумма конечная</span>
                                <input class="form-control " id="amount2" name="amount2" placeholder="0" value="111000">
                            </label>
                        </div>

                        <div class="d-flex flex-row">
                            <label>
                                <span>Описание</span>
                                <input class="form-control" name="description" placeholder="type search description" value="">
                            </label>
                        </div>

                        <div class="mt-2">
                            <span class="message addit_class"></span>
                            <button type="submit" class="btn btn-success">
                                <div class="d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise align-self-center svg spinMessage__spinSvg d-none" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                    </svg>
                                    <span class="message"></span>
                                    <span class="ml-1">Search it!</span>
                                </div>
                            </button>
                            <button type="reset" class="btn btn-primary ml-2">
                                reset
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>