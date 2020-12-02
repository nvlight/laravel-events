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
    </style>

    <main>
        <div class="container">
            <p>
                <a href="{{ url('/') }}">Home</a>
            </p>
            <h1 class="">Evento/index</h1>
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

            @if($eventosWithAllColumnsArrayFormatted)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th class="">#</th>
                            <th class="">categories</th>
                            <th class="">Date</th>
                            <th class="">Description</th>
                            <th class="">tags/vals/caps</th>
                            <th class="">actions</th>
                            <th>attachments</th>
                        </tr>
                        @foreach($eventosWithAllColumnsArrayFormatted as $eventoKey => $evento)
                            <?php //dd($evento); ?>
                            <tr data-evento-id="{{ $eventoKey }}">
                                <td class="evento_id">{{ $eventoKey }}</td>
                                <td class="category_td">
                                    <?php //dump($evento['categories']); ?>
                                    @if(count($evento['categories']))
                                        @foreach($evento['categories'] as $k => $category)
                                            <div>
                                                {{ $category['evento_category_name'] }}
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

                                <td class="">
                                    <div class="">
{{--                                        @foreach($eventoCategoryId as $eventoTagId => $eventoTags)--}}
{{--                                            @php //dd($eventoCategoryId); @endphp--}}

{{--                                            <div class="lead d-flex mt-1" >--}}
{{--                                                <small class="badge p-2" style="background-color: {{ $eventoTags['evento_tag_color'] ?? '#fff' }};">--}}
{{--                                                    <span class="">{{ $eventoTags['evento_tag_name'] }}</span>--}}
{{--                                                    @if ($eventoTags['evento_evento_tag_value_value'] !== null && $eventoTags['evento_evento_tag_value_value'] !== 0)--}}
{{--                                                        <span class="badge bg-secondary" role="button" >--}}
{{--                                                            {{ $eventoTags['evento_evento_tag_value_value'] }}--}}
{{--                                                        </span>--}}
{{--                                                    @endif--}}
{{--                                                </small>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
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
                                    <a href="{{ route('cabinet.evento.show',    $eventoKey ) }}" class="" style="text-decoration: none; color: green;">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-square-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2.5a2 2 0 0 1 1.6.8L8 14.333 9.9 11.8a2 2 0 0 1 1.6-.8H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                            <path fill-rule="evenodd" d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('cabinet.evento.edit',    $eventoKey ) }}" class="" style="text-decoration: none; color: mediumslateblue;" title="редактировать">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('cabinet.evento.destroy', $eventoKey ) }}" class="evento_delete" style="text-decoration: none; color: #C6443C;">
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
                    <h5 class="modal-title">Add Evento Category && Add Standalone Category</h5>
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
                                    Add Standalone Category
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-parent="#accordionEventoCategory">
                                <div class="accordion-body">
                                    <form action="{{ route('cabinet.evento.category.store_ajax') }}" method="POST" name="addStandaloneCategoryForm">
                                        @csrf
                                        <input type="hidden" name="category_id" value="0">
                                        <div class="modal-body">
                                            <label for="addCategoryModalId">Category</label>
                                            <input class="form-control" id="addCategoryModalId" type="text" name="name" value="" placeholder="type category">
                                            <p class="message-text resultMessage d-none">Добавлено!</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button id="addStandAloneCategoryBtnId" type="button" class="btn btn-primary">add category</button>
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
                    <h5 class="modal-title">Add tag for Evento</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- END of Modals --}}

@endsection