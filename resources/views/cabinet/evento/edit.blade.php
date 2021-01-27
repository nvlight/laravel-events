@extends('layouts.evento')

@section('content')
    <div class="container">
        <h2>Evento/edit</h2>
        <p><a href="{{ route('cabinet.evento.index') }}">Eventos</a></p>

        <table class="table table-striped table-bordered">

            @if(session()->has('created'))
                <div class="alert alert-success" role="alert">
                    {{ session()->get('created') }}
                </div>
            @endif

            @if(session()->has('saved'))
                <div class="alert alert-success" role="alert">
                    {{ session()->get('saved') }}
                </div>
            @endif

            @include('cabinet.evento._blocks.flash_message')

            <form action="{{ route('cabinet.evento.update', $evento) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="description"><b>description:</b></label>
                    <input type="text" id="description" name="description" class="form-control" value="{{ $evento->description }}">
                </div>
                <div class="form-group">
                    <label for="date"><b>date:</b></label>
                    <input type="text" id="date" name="date" class="form-control" value="{{ $evento->date }}">
                </div>
                <div class="form-group mt-2">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-danger" href="{{ route('cabinet.evento.destroy', $evento) }}">Delete</a>
                    <a class="btn btn-primary" href="{{ route('cabinet.evento.create') }}">New Evento</a>
                </div>
            </form>
        </table>
    </div>

@endsection