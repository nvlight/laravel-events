@extends('layouts.evento')

@section('content')
    <h2>Evento/EventoTagValue/Create</h2>

    <div class="card-body">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        @if($eventoTags)
            @foreach($eventoTags as $eventoTag)
                <form action="{{ route('cabinet.evento.eventotagvalue.update', $eventoTag->evento_evento_tag_values_id) }}" method="post" enctype="application/x-www-form-urlencoded">
                    @csrf
                    <div class="form-group">
                        <label><b>evento_evento_tag_value_id :-</b></label>
                        <span>{{ $eventoTag->evento_evento_tag_values_id }}</span>
                        <input type="hidden" name="evento_evento_tags_id" class="form-control" value="{{ $eventoTag->evento_evento_tag_values_id }}" >
                    </div>
                    <div class="form-group">
                        <label><b>value :-</b></label>
                        <input type="text" name="value" class="form-control" value="{{ $eventoTag->evento_evento_tag_value_value }}">
                    </div>
                    <div class="form-group">
                        <label><b>caption :-</b></label>
                        <input type="text" name="caption" class="form-control" value="{{ $eventoTag->evento_evento_tag_value_caption }}">
                    </div>

                    <div class="form-group text-center">
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            @endforeach
        @endif


    </div>

@endsection