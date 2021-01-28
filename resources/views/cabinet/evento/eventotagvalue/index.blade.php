@extends('layouts.evento')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>Evento/EventoTagValue/index</h2>

                @include('cabinet.evento.eventotagvalue.nav.breadcrumbs')
                @include('cabinet.evento.eventotagvalue.buttons.create')

                @include('cabinet.evento._blocks.flash_message')

                @if($eventoTagValues)
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-responsive">
                                @include('cabinet.evento.eventotagvalue.list.header')
                                @foreach($eventoTagValues as $eventoTagValue)
                                    @include('cabinet.evento.eventotagvalue.list.item')
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection