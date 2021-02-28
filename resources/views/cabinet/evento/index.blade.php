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
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-palette" viewBox="0 0 16 16">
                                <path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm4 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM5.5 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm.5 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                <path d="M16 8c0 3.15-1.866 2.585-3.567 2.07C11.42 9.763 10.465 9.473 10 10c-.603.683-.475 1.819-.351 2.92C9.826 14.495 9.996 16 8 16a8 8 0 1 1 8-8zm-8 7c.611 0 .654-.171.655-.176.078-.146.124-.464.07-1.119-.014-.168-.037-.37-.061-.591-.052-.464-.112-1.005-.118-1.462-.01-.707.083-1.61.704-2.314.369-.417.845-.578 1.272-.618.404-.038.812.026 1.16.104.343.077.702.186 1.025.284l.028.008c.346.105.658.199.953.266.653.148.904.083.991.024C14.717 9.38 15 9.161 15 8a7 7 0 1 0-7 7z"/>
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