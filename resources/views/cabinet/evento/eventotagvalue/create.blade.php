@extends('layouts.evento')

@section('content')
    <h2>Evento/EventoTagValue/Create</h2>

    <div class="card-body">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        <form action="{{ route('cabinet.evento.eventotagvalue.store') }}" method="post" enctype="application/x-www-form-urlencoded">
            @csrf
            <div class="form-group">
                <label><b>evento_evento_tags_id :-</b></label>
                <select name="evento_evento_tags_id" id="evento_evento_tags_id">
                    @foreach($eventoTags as $eventoTag)
                        <option value="{{ $eventoTag->evento_evento_tag_id }}">
                            {{ $eventoTag->evento_evento_tag_id }} - {{ $eventoTag->evento_description }} - {{ $eventoTag->tag_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label><b>value :-</b></label>
                <input type="text" name="value" class="form-control" value="{{ old('value') }}">
            </div>
            <div class="form-group">
                <label><b>caption :-</b></label>
                <input type="text" name="caption" class="form-control" value="{{ old('caption') }}">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </form>
    </div>

@endsection