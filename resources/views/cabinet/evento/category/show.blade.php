@extends('layouts.evento')

@section('content')

    <div class="container">

        <h2>Evento/Category/Show</h2>

        @include('cabinet.evento.category.nav.breadcrumbs')

        <div class="d-flex">
            @include('cabinet.evento.category.buttons.create')
            @include('cabinet.evento.category.buttons.delete', ['categoryId' => $category->id, 'class' => 'btn-danger ml-2' ] )
        </div>

        <div class="row">
            <div class="col-md-4">

                <div class="card" style="width: 18rem;">
                    <div class=" card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Column</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            @foreach($category->attributesToArray() as $k => $v)
                                <tr>
                                    <th>{{ $k  }}</th>
                                    <td>{{ $v }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection