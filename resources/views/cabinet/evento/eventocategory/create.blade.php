@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Evento/EventoCategory/Create</h2>

                @include('cabinet.evento.eventocategory.nav.breadcrumbs')
                @include('cabinet.evento.eventocategory.buttons.create')

                <div class="card">
                    <div class="card-body">

                        @include('cabinet.evento.eventocategory.list.errors')
                        @include('cabinet.evento.eventocategory.flash.message')

                        <form action="{{ route('cabinet.evento.eventocategory.store') }}" method="post" enctype="application/x-www-form-urlencoded">
                            @csrf
                            <div class="form-group">
                                <label class="w-100">
                                    <b>evento_id</b>
                                    <select name="evento_id" class="form-control w-100">
                                        <option>0</option>
                                        @foreach($eventos as $evento)
                                            <option value="{{ $evento->id }}">{{ $evento->description }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="w-100">
                                    <b>category_id</b>
                                    <select name="category_id" class="form-control w-100">
                                        <option>0</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
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