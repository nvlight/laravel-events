@extends('layouts.evento')

@section('content')
    <h2>Evento/Attachments/Create</h2>

    <div class="card-body">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger">{{ session()->get('error') }}</div>
        @endif

        <form action="{{ route('cabinet.evento.attachment.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label><b>evento_id :-</b></label>
                <select name="evento_id" >
                    <option>0</option>
                    @foreach($eventos as $evento)
                        <option value="{{ $evento->id }}">{{ $evento->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label><b>file :-</b></label>
                <input type="file" name="file" class="form-control" value="{{ old('file') }}">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </form>
    </div>

@endsection