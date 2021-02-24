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
                <p>Evento count: {{ $eventoCount }}</p>
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
    {{-- END of Modals --}}

    @push('footer_js')
        <script src="{{ asset('flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('js/evento.main.js') }}"></script>
    @endpush

@endsection