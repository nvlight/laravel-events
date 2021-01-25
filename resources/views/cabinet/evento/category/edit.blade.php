@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2>Evento/Category/Edit</h2>

                @include('cabinet.evento.category.nav.breadcrumbs')

                <div class="d-flex">
                    @include('cabinet.evento.category.buttons.create')
                    @include('cabinet.evento.category.buttons.delete', ['categoryId' => $category->id, 'class' => 'btn-danger ml-2' ] )
                </div>

                @include('cabinet.evento.category.flash.message')

                <div class="card">
                    <div class="card-body">
                        @if(count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif

                        <form action="{{ route('cabinet.evento.category.update', $category) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="w-100">
                                    <b>name</b>
                                    <input type="text" name="name" class="form-control w-100" value="{{ $category->name }}">
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="w-100">
                                    <b>parent_id</b>
                                </label>
                                <select name="parent_id" class="form-control w-100">
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
                                <label class="w-100">
                                    <b>Img</b>
                                    <input type="file" name="img" class="form-control" value="{{ $category->img }}">
                                </label>
                            </div>
                            <div class="form-group mt-2">
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection