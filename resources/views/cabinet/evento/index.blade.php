@extends('layouts.evento')

@section('content')
    <style>
        .accordion-item:first-of-type .accordion-button {
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
        }
        .accordion-button:not(.collapsed) {
            color: #0c63e4;
            background-color: #e7f1ff;
        }
        [type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {
            cursor: pointer;
        }
        .accordion-button {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            color: #212529;
            background-color: transparent;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: 0;
            overflow-anchor: none;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,border-radius .15s ease;
        }
        .color-green{
            color: green;
        }
        .color-red{
            color: red;
        }
        .w20{
            width: 20px;
        }
        .h20{
            height: 20px;
        }
        .curp{
            cursor: pointer;
        }
        .add-category-crud--buttons{

        }
    </style>

    <main>
        <div class="container">
            <p>
                <a href="/">Home</a>
            </p>
            <h2 class="">Evento/index</h2>

            <p class="d-flex justify-content-around">
                <a class="" href="{{ route('cabinet.evento.create') }}">create evento</a>
                <a class="" href="{{ route('cabinet.evento.category.index') }}">category</a>
                <a class="" href="{{ route('cabinet.evento.tag.index') }}">tag</a>
                <a class="" href="{{ route('cabinet.evento.eventocategory.index') }}">eventoCategory</a>
                <a class="" href="{{ route('cabinet.evento.eventotag.index') }}">eventoTag</a>
                <a class="" href="{{ route('cabinet.evento.eventotagvalue.index') }}">eventoTagValue</a>
                <a class="" href="{{ route('cabinet.evento.attachment.index') }}">attachments</a>
            </p>

            @include('cabinet.evento._blocks.flash_message')

            @if($eventos)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped ">
                        @include('cabinet.evento._inner.list.header')
                        @foreach($eventos as $eventoKey => $evento)
                            @include('cabinet.evento._inner.list.item')
                        @endforeach
                    </table>
                </div>

                {{ $paginator->links() }}
            @endif

        </div>

    </main>



    {{-- Modals --}}
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
                                        <div class="crud_categories">

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
    {{-- END of Modals --}}

@endsection