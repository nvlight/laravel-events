@extends('layouts.evento')

@section('content')
    <div class="container">
        <h2>Evento/Create</h2>
        <p><a href="{{ route('cabinet.evento.index') }}">Eventos</a></p>

        <table class="table table-striped table-bordered">
            @if(count($errors) > 0)
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif

            <form action="{{ route('cabinet.evento.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="description"><b>description:</b></label>
                    <input type="text" id="description" name="description" class="form-control" value="{{ old('description') }}">
                </div>
                <div class="form-group">
                    <label for="date"><b>date:</b></label>
                    <input type="text" id="date" name="date" class="form-control" value="{{ old('date') }}">
                </div>
                <div class="form-group mt-2">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </table>
    </div>
@endsection