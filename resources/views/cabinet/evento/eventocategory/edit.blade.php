@extends('layouts.evento')

@section('content')
    <h2>Evento/EventoCategory/Edit</h2>

    <div class="card-body">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        <form action="{{ route('cabinet.evento.eventocategory.update', $eventocategory) }}" method="post" enctype="application/x-www-form-urlencoded">
            @csrf
            <input type="hidden" name="evento_id" value="{{ $evento->id }}">

            <div class="form-group">
                <label><b>evento_name :-</b></label>
                <span>{{ $evento->description }}</span>
            </div>
            <div class="form-group">
                <label><b>category_id :-</b></label>
                <select name="category_id" >
                    <option>0</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @if($eventocategory->category_id == $category->id)
                                selected
                            @endif
                        >
                            {{ $category->name }}
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