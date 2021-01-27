@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Evento/EventoTag/Edit</h2>

                @include('cabinet.evento.eventotag.nav.breadcrumbs')

                <div class="d-flex">
                    @include('cabinet.evento.eventotag.buttons.create')
                    @include('cabinet.evento.eventotag.buttons.delete', ['itemId' => $eventotag->id, 'class' => 'btn-danger ml-2' ] )
                </div>

                <div class="card">
                    <div class="card-body">

                        @include('cabinet.evento._blocks.errors')
                        @include('cabinet.evento._blocks.flash_message')

                        <form action="{{ route('cabinet.evento.eventotag.update', $eventotag) }}" method="post" enctype="application/x-www-form-urlencoded">
                            @csrf
                            <input type="hidden" name="evento_id" value="{{ $evento->id }}">

                            <div class="form-group">
                                <label class="w-100">
                                    <b>evento_name</b>
                                    <span class="form-control w-100">{{ $evento->description }}</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="w-100">
                                    <b>tag_id</b>
                                    <select name="tag_id" class="form-control w-100">
                                        <option>0</option>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}"
                                                    @if($eventotag->tag_id == $tag->id) selected @endif >
                                                {{ $tag->name }}
                                            </option>
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