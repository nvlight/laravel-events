@extends('layouts.evento')

@section('content')
    <div class="container">
        <h2>Evento/Category/index</h2>

        @include('cabinet.evento.category.nav.breadcrumbs')
        @include('cabinet.evento.category.buttons.create')

        @if($categories)
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                @include('cabinet.evento.category.list.header')
                                <tbody>
                                    @foreach($categories as $category)
                                        @include('cabinet.evento.category.list.item')
                                    @endforeach
                                </tbody>
                                {{-- @include('cabinet.evento.category.list.footer')--}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection