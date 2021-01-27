@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <h2>Evento/EventoTag/Create</h2>

                @include('cabinet.evento.eventotag.nav.breadcrumbs')
                @include('cabinet.evento.eventotag.buttons.create')

                <div class="card">
                    <div class="card-body">

                        @include('cabinet.evento._blocks.errors')
                        @include('cabinet.evento._blocks.flash_message')

                        <form action="{{ route('cabinet.evento.eventotag.store') }}" method="post" enctype="multipart/form-data">
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
                                    <b>tag_id</b>
                                    <select name="tag_id" class="form-control w-100">
                                        <option>0</option>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
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