@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <h2>Evento/EventoTagValue/Create</h2>

                @include('cabinet.evento.eventotagvalue.nav.breadcrumbs')

                <div class="card">
                    <div class="card-body">

                        @include('cabinet.evento._blocks.errors')
                        @include('cabinet.evento._blocks.flash_message')

                        <form action="{{ route('cabinet.evento.eventotagvalue.store') }}" method="post" enctype="application/x-www-form-urlencoded">
                            @csrf
                            <div class="form-group">
                                <label><b>evento_evento_tags_id</b>
                                    <select name="evento_evento_tags_id" class="form-control w-100">
                                        @foreach($eventoTags as $eventoTag)
                                            <option value="{{ $eventoTag->evento_evento_tag_id }}">
                                                {{ $eventoTag->evento_evento_tag_id }} - {{ $eventoTag->evento_description }} - {{ $eventoTag->tag_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <b>value</b>
                                    <input type="text" name="value" class="form-control" value="{{ old('value') }}">
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <b>caption</b>
                                    <input type="text" name="caption" class="form-control" value="{{ old('caption') }}">
                                </label>
                            </div>
                            <div class="form-group mt-2">
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection