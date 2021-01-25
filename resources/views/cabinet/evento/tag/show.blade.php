@extends('layouts.evento')

@section('content')

    <div class="container">

    <h2>Evento/Tag/Show</h2>

        @include('cabinet.evento.tag.nav.breadcrumbs')

        <div class="d-flex">
            @include('cabinet.evento.tag.buttons.create')
            @include('cabinet.evento.tag.buttons.delete', ['tagId' => $tag->id, 'class' => 'btn-danger ml-2'])
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
                            @forelse($tag->attributesToArray() as $k => $v)
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