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
                <a href="{{ url('/') }}">Home</a>
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

            @if(session()->has('deleted'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('deleted') }}
                </div>
            @endif

            @if($eventos)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th class="">#</th>
                            <th class="">categories</th>
                            <th class="">Description</th>
                            <th class="">Date</th>
                            <th class="">tags/vals/caps</th>
                            <th class="">actions</th>
                            <th>attachments</th>
                        </tr>
                        @foreach($eventos as $eventoKey => $evento)
                            <?php //dd($evento); ?>
                            <tr data-evento-id="{{ $evento['evento']['evento_id'] }}">
                                <td class="evento_id">{{ $evento['evento']['evento_id'] }}</td>
                                <td class="category_td">
                                    <?php //dump($evento['categories']); ?>
                                    @if(count($evento['categories']))
                                        @foreach($evento['categories'] as $k => $category)
                                            <div>
                                                <span class="categoryNameText" data-textValue="{{ $category['evento_category_name'] }}">{{ $category['evento_category_name'] }}</span>
                                                <?php // {{ route('cabinet.evento.eventocategory.destroy', $category['evento_evento_category_id']) }} ?>
                                                <a href=""
                                                   class="delete_category" data-categoryId="{{ $category['evento_evento_category_id'] }}">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg" role="button">
                                                        <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif

                                    {{-- add new category Icon --}}
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                         data-toggle="modal" data-target="#add-category-modal" role="button">
                                        <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                    </svg>
                                </td>
                                <td class="">{{ $evento['evento']['evento_description'] }}</td>
                                <td class="">{{ $evento['evento']['date'] }}</td>

                                <td class="tag_td">
                                    <div class="">
                                        @if(count($evento['tags']))
                                            @foreach($evento['tags'] as $k => $tag)
                                                <div>
                                                    {{ $tag['evento_tag_name'] }}
                                                    @if ($tag['evento_evento_tag_value_value'])
                                                        ({{ $tag['evento_evento_tag_value_value'] }})
                                                    @endif
                                                    <?php // {{ route('cabinet.evento.eventocategory.destroy', $category['evento_evento_category_id']) }} ?>
                                                    <a href=""
                                                       class="delete_tag" data-tagId="{{ $tag['evento_evento_tag_id'] }}">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg" role="button">
                                                            <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    {{-- add new tag Icon --}}
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                         data-toggle="modal" data-target="#add-tag-modal" role="button">
                                        <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                    </svg>
                                </td>
                                <td class="border px-4 py-2">
                                    @php //$fistCategoryForEventoId = array_key_first($eventoId); dd($eventoId[$fistCategoryForEventoId][0]['evento_id']); @endphp
                                    <?php //dd($eventoId); ?>
                                    <a href="{{ route('cabinet.evento.show',    $evento['evento']['evento_id'] ) }}" class="" style="text-decoration: none; color: green;">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-square-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2.5a2 2 0 0 1 1.6.8L8 14.333 9.9 11.8a2 2 0 0 1 1.6-.8H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                            <path fill-rule="evenodd" d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('cabinet.evento.edit',    $evento['evento']['evento_id'] ) }}" class="" style="text-decoration: none; color: mediumslateblue;" title="редактировать">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('cabinet.evento.destroy', $evento['evento']['evento_id'] ) }}" class="evento_delete" style="text-decoration: none; color: #C6443C;">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td>
                                    <a href="">add new</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                {{ $paginator->links() }}

            @endif

        </div>

    </main>

    <footer class="">
        <div class="container">
            <p class="">© <script>document.write(new Date().getFullYear())</script> Evento
            </p>
        </div>
    </footer>

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
                                    <form action="{{ route('cabinet.evento.eventotag.store_ajax') }}" method="POST" name="addTagForm">
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
                                    Add Standalone Tag
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
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button id="addStandAloneTagBtnId" type="button" class="btn btn-primary">add tag</button>
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