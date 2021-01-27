@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <h2>Evento/EventoCategory/index</h2>

                @include('cabinet.evento.eventocategory.nav.breadcrumbs')
                @include('cabinet.evento.eventocategory.buttons.create')

                @include('cabinet.evento._blocks.flash_message')

                @if($eventocategories)
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-responsive">
                                @include('cabinet.evento.eventocategory.list.header')
                                @foreach($eventocategories as $eventocatetory)
                                    @include('cabinet.evento.eventocategory.list.item')
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection