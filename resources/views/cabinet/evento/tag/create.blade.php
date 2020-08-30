@extends('layouts.evento')

@section('content')
    <h2>Evento/Tag/Create</h2>

    <div class="card-body">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        <form action="{{ route('cabinet.evento.tag.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label><b>name :-</b></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label><b>color :-</b></label>
                <input type="text" name="color" class="form-control" value="{{ old('color') }}">
            </div>
            <div class="form-group">
                <label><b>Img :-</b></label>
                <input type="file" name="img" class="form-control" value="{{ old('img') }}">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </form>
    </div>

@endsection