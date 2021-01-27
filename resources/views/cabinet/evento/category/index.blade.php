@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <h2>Evento/Category/index</h2>

                @include('cabinet.evento.category.nav.breadcrumbs')
                @include('cabinet.evento.category.buttons.create')

                @include('cabinet.evento._blocks.flash_message')

                @if($categories)
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
                @endif
            </div>
        </div>
    </div>
@endsection