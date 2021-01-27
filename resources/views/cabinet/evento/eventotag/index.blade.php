@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <h2>Evento/EventoTag/index</h2>

                @include('cabinet.evento.eventotag.nav.breadcrumbs')
                @include('cabinet.evento.eventotag.buttons.create')

                @include('cabinet.evento._blocks.flash_message')

                @if($eventotags)
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-responsive">
                                @include('cabinet.evento.eventotag.list.header')
                                @foreach($eventotags as $eventotag)
                                    @include('cabinet.evento.eventotag.list.item')
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection