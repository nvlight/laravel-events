@extends('layouts.evento')

@section('content')
    <h2>Evento/Create</h2>

    <div class="card-body">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        <form action="{{ route('cabinet.evento.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label><b>description :-</b></label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}">
            </div>
            <div class="form-group">
                <label><b>date :-</b></label>
                <input type="text" name="date" class="form-control" value="{{ old('date') }}">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </form>
    </div>

@endsection