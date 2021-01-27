@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <h2>Evento/Tag/index</h2>

                @include('cabinet.evento.tag.nav.breadcrumbs')
                @include('cabinet.evento.tag.buttons.create')

                @include('cabinet.evento._blocks.flash_message')

                <div class="card">
                    <div class="card-body">
                        @if($tags)
                        <table class="table table-striped table-bordered">
                            @include('cabinet.evento.tag.list.header')
                            @foreach($tags as $tag)
                                @include('cabinet.evento.tag.list.item')
                            @endforeach
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection