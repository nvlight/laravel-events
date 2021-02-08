@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                <h2>Evento/Show</h2>
                <p><a href="{{ route('cabinet.evento.index') }}">Eventos</a></p>

                @include('cabinet.evento._inner.get_evento_table')
                @include('cabinet.evento._inner.get_evento_edit_delete_buttons')

            </div>
        </div>
    </div>
@endsection