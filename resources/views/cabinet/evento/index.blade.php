@extends('layouts.evento')

@section('content')
    <main>
        <div class="container">
            <p>
                <a href="{{ url('/') }}">Home</a>
            </p>
            <h1 class="">Evento/index</h1>
            <p class="">
                <a class="" href="{{ route('cabinet.evento.create') }}">create new evento</a>
                <a class="" href="{{ route('cabinet.evento.category.index') }}">category/index</a>
                <a class="" href="{{ route('cabinet.evento.tag.index') }}">tag/index</a>
                <a class="" href="{{ route('cabinet.evento.eventocategory.index') }}">eventoCategory/index</a>
                <a class="" href="{{ route('cabinet.evento.eventotag.index') }}">eventoTag/index</a>
                <a class="" href="{{ route('cabinet.evento.eventotagvalue.index') }}">eventoTagValue/index</a>
                <a class="" href="{{ route('cabinet.evento.attachment.index') }}">attachment/index</a>
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
                            <th class="">Description</th>
                            <th class="">Date</th>
                            <th class="">categories</th>
                            <th class="">tags/vals/caps</th>
                            <th class="">actions</th>
                            <th>attachments</th>
                        </tr>
                        @foreach($eventosWithAllColumnsArrayFormatted as $eventoKey => $eventoId)
                            @foreach($eventoId as $categoryKey => $eventoCategoryId)
                                <tr data-evento-id="{{$eventoCategoryId[0]['evento_id'] }}">
                                    <td class="evento_id">{{$eventoCategoryId[0]['evento_id'] }}</td>
                                    <td class="">{{$eventoCategoryId[0]['evento_description'] }}</td>
                                    <td class="">{{$eventoCategoryId[0]['date'] }}</td>
                                    <td class="category_td">
                                        @if($eventoCategoryId[0]['evento_category_name'])
                                            <div>
                                                {{ $eventoCategoryId[0]['evento_category_name'] }} <a href="{{ route('cabinet.evento.eventocategory.destroy', $eventoCategoryId[0]['evento_evento_category_id']) }}" class="delete_category" data-categoryId="{{ $eventoCategoryId[0]['evento_evento_category_id'] }}">delete</a>
                                            </div>
                                        @endif

                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-category-modal">
                                            add category
                                        </button>
                                    </td>
                                    <td class="">
                                        <div class="">
                                            @foreach($eventoCategoryId as $eventoTagId => $eventoTags)
                                                @php //dd($eventoCategoryId); @endphp

                                                <div class="lead d-flex mt-1" >
                                                    <small class="badge p-2" style="background-color: {{ $eventoTags['evento_tag_color'] ?? '#fff' }};">
                                                        <span class="">{{ $eventoTags['evento_tag_name'] }}</span>
                                                        @if ($eventoTags['evento_evento_tag_value_value'] !== null && $eventoTags['evento_evento_tag_value_value'] !== 0)
                                                            <span class="badge bg-secondary" role="button" >
                                                                {{ $eventoTags['evento_evento_tag_value_value'] }}
                                                            </span>
                                                        @endif
                                                    </small>
                                                </div>

                                            @endforeach
                                        </div>
                                        <br>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-tag-modal">
                                            add tag
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-tagvalue-modal">
                                            add tag value
                                        </button>
                                    </td>
                                    <td class="border px-4 py-2">
                                        @php //$fistCategoryForEventoId = array_key_first($eventoId); dd($eventoId[$fistCategoryForEventoId][0]['evento_id']); @endphp
                                        <?php //dd($eventoId); ?>
                                        <a href="{{ route('cabinet.evento.show',    $eventoKey ) }}" class="">show</a>
                                        <a href="{{ route('cabinet.evento.edit',    $eventoKey ) }}" class="">edit</a>
                                        <a href="{{ route('cabinet.evento.destroy', $eventoKey ) }}" class="">delete</a>
                                        <br>


                                    </td>
                                    <td>
                                        <a href="">add new</a>
                                    </td>
                                </tr>
                            @endforeach
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

    <div class="modal fade" id="add-category-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add category for Evento</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('cabinet.evento.eventocategory.store_ajax') }}" method="POST" name="addCategoryForm">
                    <div class="modal-body">
                        <p>Choose need category</p>
                        <select name="categories" class="form-select">
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        @csrf
                        <input type="hidden" name="evento_id" value="0">
                        <input type="hidden" name="category_id" value="0">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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

    <div class="modal fade" id="add-tagvalue-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add tag value for Evento tag</h5>
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
@endsection