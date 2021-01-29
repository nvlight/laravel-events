@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>Evento/Attachments/index</h2>

                @include('cabinet.evento.attachment.nav.breadcrumbs')
                @include('cabinet.evento.attachment.buttons.create')

                @include('cabinet.evento._blocks.flash_message')

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            @include('cabinet.evento.attachment.list.header')
                            @if($attachments->count())
                                @each('cabinet.evento.attachment.list.item', $attachments, 'attachment')
                            @else
                                <tr>
                                    <td colspan="9" class="text-center font-weight-bold text-danger">No items!</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection