<div class="modal fade" id="tagvalue-gistogramm-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tag values gistogramm</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="monthGistogrammCanvas"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="align-self: center;">
                            <legend for="monthGistogrammCanvas"></legend>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <form action="<?php echo e(route('cabinet.evento.eventotagcounting.get_month_gistogramm_by_year_ajax')); ?>"
                          name="monthDiagrammByYear" class="d-inline-flex spinMessage__wrapper getMonthDiagrammByYear__wrapper">
                        <div class="col-md-7">
                            <select name="year" class="form-select"></select>
                        </div>
                        <div class="col-md-5">
                            <div class="text-right">
                                <span class="message addit_class"></span>
                                <button type="submit" class="btn btn-primary">
                                    <div class="d-flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise align-self-center svg spinMessage__spinSvg d-none" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                        </svg>
                                        <span class="message"></span>
                                        <span class="ml-1">Get it!</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/cabinet/evento/_inner/modals/gistogramms/tag_values.blade.php ENDPATH**/ ?>