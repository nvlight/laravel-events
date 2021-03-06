@extends('layouts.evento')

@section('content')

    <div class="container">

        <h2>Evento/Category/Show</h2>

        @include('cabinet.evento.category.nav.breadcrumbs')

        <div class="d-flex">
            @include('cabinet.evento.category.buttons.create')
            @include('cabinet.evento.category.buttons.update', ['itemId' => $category->id, 'class' => 'btn-warning ml-2' ] )
            @include('cabinet.evento.category.buttons.delete', ['itemId' => $category->id, 'class' => 'btn-danger ml-2' ] )
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Column</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            @forelse($category->attributesToArray() as $k => $v)
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