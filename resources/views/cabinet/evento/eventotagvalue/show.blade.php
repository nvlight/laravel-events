@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                <h2>Evento/EventoTagValue/Show</h2>

                @include('cabinet.evento.eventotagvalue.nav.breadcrumbs')

                <div class="d-flex">
                    @include('cabinet.evento.eventotagvalue.buttons.create')
                    @include('cabinet.evento.eventotagvalue.buttons.update', ['itemId' => $eventoTagValue->id, 'class' => 'btn-warning ml-2' ] )
                    @include('cabinet.evento.eventotagvalue.buttons.delete', ['itemId' => $eventoTagValue->id, 'class' => 'btn-danger ml-2' ] )
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Column</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            @forelse($eventoTagValue->attributesToArray() as $k => $v)
                                <tr>
                                    <th>{{ $k  }}</th>
                                    <td>{{ $v }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">Список пуст</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection