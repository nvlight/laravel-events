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
                        <a id="tagValuesPieDiagrammSvg" href="" title="Pie Diagramm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-columns-gap" viewBox="0 0 16 16">
                                <path d="M6 1v3H1V1h5zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12v3h-5v-3h5zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8v7H1V8h5zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6v7h-5V1h5zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z"/>
                            </svg>
                        </a>
                    </p>
                    <p>
                        <a id="tagValuesMonthGistogrammSvg" href="" title="Month Diagramm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-file-earmark-bar-graph" viewBox="0 0 16 16">
                                <path d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"/>
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                            </svg>
                        </a>
                    </p>
                    <p>
                        <a id="mainFilter" href="" title="Filter it!">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" fill="currentColor" class="bi bi-filter-square" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path d="M6 11.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </a>
                    </p>
                    <p>
                        <a onclick="return false;" href="" title="Convert 2 XLS">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z"/>
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
    @include('cabinet.evento._inner.modals.gistogramms.tag_values')
    @include('cabinet.evento._inner.modals.filter_main')
    @include('cabinet.evento._inner.modals.filtered_result')
    {{-- END of Modals --}}

    @push('footer_js')
        <script src="{{ asset('flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('js/evento.main.js') }}"></script>
    @endpush

@endsection