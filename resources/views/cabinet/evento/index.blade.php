@extends('layouts.evento')

@section('content')
    <style>
        .accordion-item:first-of-type .accordion-button {
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
        }
        .accordion-button:not(.collapsed) {
            color: #0c63e4;
            background-color: #e7f1ff;
        }
        [type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {
            cursor: pointer;
        }
        .accordion-button {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            color: #212529;
            background-color: transparent;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: 0;
            overflow-anchor: none;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,border-radius .15s ease;
        }
        .color-green{
            color: green;
        }
        .color-red{
            color: red;
        }
        .w20{
            width: 20px;
        }
        .h20{
            height: 20px;
        }
        .curp{
            cursor: pointer;
        }
        .add-category-crud--buttons{

        }
    </style>

    <main>
        <div class="container">

            <h2 class=""><a href="/">Home</a>/Evento/index</h2>

            @include('cabinet.evento._inner.first_menu_line_without_js')
            @include('cabinet.evento._inner.first_menu_line_with_js')

            @include('cabinet.evento._blocks.flash_message')

            @if($eventos)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped ">
                        @include('cabinet.evento._inner.list.header')
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
    {{-- END of Modals --}}

@endsection