@extends('layouts.evento')

@section('content')
    @push('header_styles')
        <link rel="stylesheet" href="{{ asset('css/evento/evento.index.css') }}">
        <link rel="stylesheet" href="{{ asset('flatpickr/flatpickr.min.css') }}">
    @endpush

    <main>
        <div class="container">

            <h2 class=""><a href="/">Home</a>/Evento/index</h2>

            @include('cabinet.evento._inner.first_menu_line_without_js')
            @include('cabinet.evento._inner.first_menu_line_with_js')

            @include('cabinet.evento._blocks.flash_message')

            @if($eventos)
                <div class="controls d-flex justify-content-around">
                    <p>Evento count: {{ $eventoCount }}</p>
                    <p>
                        <a id="tagValuesPieDiagrammSvg" href="" title="Show TagValues Pie Diagramm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-columns-gap" viewBox="0 0 16 16">
                                <path d="M6 1v3H1V1h5zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12v3h-5v-3h5zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8v7H1V8h5zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6v7h-5V1h5zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z"/>
                            </svg>
                        </a>
                    </p>
                    <p>
                        <a href="" onclick="return false;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-file-earmark-bar-graph" viewBox="0 0 16 16">
                                <path d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"/>
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                            </svg>
                        </a>
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="eventos_table table table-bordered table-striped ">
                        <thead>
                            @include('cabinet.evento._inner.list.header')
                        </thead>
                        @foreach($eventos as $eventoKey => $evento)
                            @include('cabinet.evento._inner.list.item')
                        @endforeach
                    </table>
                </div>

                {{ $paginator->links() }}
            @endif

        </div>

    </main>

    {{-- Modals --}}
    @include('cabinet.evento._inner.modals.add_category')
    @include('cabinet.evento._inner.modals.add_tag')
    @include('cabinet.evento._inner.modals.add_attachment')
    @include('cabinet.evento._inner.modals.add_evento')
    @include('cabinet.evento._inner.modals.show_evento')
    @include('cabinet.evento._inner.modals.edit_evento')
    @include('cabinet.evento._inner.modals.edit_tag')
    @include('cabinet.evento._inner.modals.edit_category')
    @include('cabinet.evento._inner.modals.diagramms.tagvalues_by_year')
    {{-- END of Modals --}}

    @push('footer_js')
        <script src="{{ asset('flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('js/evento.main.js') }}"></script>
    @endpush

@endsection