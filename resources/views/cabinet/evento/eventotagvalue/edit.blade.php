@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <h2>Evento/EventoTagValue/Update</h2>

                @include('cabinet.evento.eventotagvalue.nav.breadcrumbs')

                <div class="card">
                    <div class="card-body">

                        @include('cabinet.evento._blocks.errors')
                        @include('cabinet.evento._blocks.flash_message')

                        @if($eventoTags)
                            @foreach($eventoTags as $eventoTag)
                                <form action="{{ route('cabinet.evento.eventotagvalue.update', $eventoTag->evento_evento_tag_values_id) }}" method="post" enctype="application/x-www-form-urlencoded">
                                    @csrf
                                    <div class="form-group">
                                        <label class="d-flex flex-column w-100">
                                            <b>evento_evento_tag_value_id</b>
                                            <span>{{ $eventoTag->evento_evento_tag_values_id }}</span>
                                            <input type="hidden" name="evento_evento_tags_id" class="form-control" value="{{ $eventoTag->evento_evento_tag_values_id }}" >
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="w-100">
                                            <b>value</b>
                                            <input type="text" name="value" class="form-control" value="{{ $eventoTag->evento_evento_tag_value_value }}">
                                        </label>

                                    </div>
                                    <div class="form-group">
                                        <label class="w-100">
                                            <b>caption</b>
                                            <input type="text" name="caption" class="form-control" value="{{ $eventoTag->evento_evento_tag_value_caption }}">
                                        </label>
                                    </div>

                                    <div class="form-group mt-2">
                                        <button class="btn btn-success" type="submit">Save</button>
                                    </div>
                                </form>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>

@endsection