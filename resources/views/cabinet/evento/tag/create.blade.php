@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                <h2>Evento/Tag/Create</h2>

                @include('cabinet.evento.tag.nav.breadcrumbs')
                @include('cabinet.evento.tag.flash.message')

                <div class="card">
                    <div class="card-body">

                        @include('cabinet.evento.tag.list.errors')

                        <form action="{{ route('cabinet.evento.tag.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="w-100">
                                    <b>name</b>
                                    <input type="text" name="name" class="form-control  w-100" value="{{ old('name') }}">
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="w-100">
                                    <b>color</b>
                                    <input type="text" name="color" class="form-control w-100" value="{{ old('color') }}">
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="w-100">
                                    <b>Img</b>
                                    <input type="file" name="img" class="form-control w-100" value="{{ old('img') }}">
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