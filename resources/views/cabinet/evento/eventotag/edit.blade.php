@extends('layouts.evento')

@section('content')
    <h2>Evento/EventoTag/Edit</h2>

    <div class="card-body">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        <form action="{{ route('cabinet.evento.eventotag.update', $eventotag) }}" method="post" enctype="application/x-www-form-urlencoded">
            @csrf
            <input type="hidden" name="evento_id" value="{{ $evento->id }}">

            <div class="form-group">
                <label><b>evento_name :-</b></label>
                <span>{{ $evento->description }}</span>
            </div>
            <div class="form-group">
                <label><b>tag_id :-</b></label>
                <select name="tag_id" >
                    <option>0</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}"
                            @if($eventotag->tag_id == $tag->id)
                                selected
                            @endif
                        >
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </form>

    </div>

@endsection