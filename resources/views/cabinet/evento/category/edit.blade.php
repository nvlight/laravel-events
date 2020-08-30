@extends('layouts.evento')

@section('content')
    <h2>Evento/Category/Edit</h2>

    <div class="card-body">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        <form action="{{ route('cabinet.evento.category.update', $category) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label><b>name :-</b></label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}">
            </div>
            <div class="form-group">
                <label><b>parent_id :-</b></label>
                <select name="parent_id" id="">
                    <option>0</option>
                    @foreach($categoryIds as $id)
                        <option
                            @if($category->parent_id == $id)
                                selected
                            @endif
                        >
                            {{ $id }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label><b>Img :-</b></label>
                <input type="file" name="img" class="form-control" value="{{ $category->img }}">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </form>

    </div>

@endsection