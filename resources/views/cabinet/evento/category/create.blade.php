@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2>Evento/Category/Create</h2>

                @include('cabinet.evento.category.nav.breadcrumbs')
                @include('cabinet.evento.category.flash.message')

                <div class="card">
                    <div class="card-body">

                        @include('cabinet.evento._blocks.flash_message')

                        <form action="{{ route('cabinet.evento.category.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="w-100">
                                    <b>name</b>
                                    <input type="text" name="name" class="form-control w-100" value="{{ old('name') }}">
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="w-100">
                                    <b>parent_id</b>
                                </label>
                                <select name="parent_id" class="form-control w-100">
                                    <option>0</option>
                                    @foreach($categoryIds as $id)
                                        <option>{{ $id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="w-100">
                                    <b>Img</b>
                                    <input type="file" name="img" class="form-control" value="{{ old('img') }}">
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