@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Evento/Attachment/Show</h2>

                @include('cabinet.evento.attachment.nav.breadcrumbs')
                <div class="d-flex">
                    @include('cabinet.evento.attachment.buttons.create')
                    @include('cabinet.evento.attachment.buttons.update', ['itemId' => $attachment->id, 'class' => 'btn-warning ml-2'])
                    @include('cabinet.evento.attachment.buttons.delete', ['itemId' => $attachment->id, 'class' => 'btn-danger ml-2'])
                </div>

                @include('cabinet.evento._blocks.flash_message')

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Column</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            @foreach($attachment->attributesToArray() as $k => $v)
                                <tr>
                                    <th>{{ $k  }}</th>
                                    <td>{{ $v }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection