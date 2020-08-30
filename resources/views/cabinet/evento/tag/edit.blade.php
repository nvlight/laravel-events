@extends('layouts.evento')

@section('content')
    <h2>Evento/Tag/Create</h2>

    <div class="card-header bg-success">
        <h3 class="text-white text-center"><strong>Image Validation in Laravel</strong></h3>
    </div>
    <div class="card-body">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        @if (\Session::has('event_tag_updated'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ \Session::get('event_tag_updated') }}</li>
                </ul>
            </div>
        @endif

        <form action="{{ route('cabinet.evento.tag.update', $tag) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label><b>name :-</b></label>
                <input type="text" name="name" class="form-control" value="{{ $tag->name }}">
            </div>
            <div class="form-group">
                <label><b>color :-</b></label>
                <input type="text" name="color" class="form-control" value="{{ $tag->color }}">
            </div>
            <div class="form-group">
                <label><b>Imh :-</b></label>
                <input type="file" name="img" class="form-control" value="{{ $tag->img }}">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </form>
    </div>

@endsection