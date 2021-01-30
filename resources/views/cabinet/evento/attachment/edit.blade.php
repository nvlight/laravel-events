@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Evento/Attachment/edit</h2>

                @include('cabinet.evento.attachment.nav.breadcrumbs')

                <div class="d-flex">
                    @include('cabinet.evento.attachment.buttons.create')
                    @include('cabinet.evento.attachment.buttons.delete', ['itemId' => $attachment->id, 'class' => 'btn-danger ml-2'])
                </div>

                @include('cabinet.evento._blocks.flash_message')

                <div class="card">
                    <div class="card-body">
                        @include('cabinet.evento._blocks.errors')
                        <form action="{{ route('cabinet.evento.attachment.update', $attachment) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="w-100">
                                    <b>evento_id</b>
                                    <select name="evento_id" class="form-control w-100">
                                        <option>0</option>
                                        @foreach($eventos as $evento)
                                            <option value="{{ $evento->id }}"
                                                @if($evento->id == $attachment->evento_id) selected @endif
                                            >{{ $evento->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <div class="form-group">
                                <label><b>current_file: {{ $fileName }}</b></label>
                                <input type="file" name="file" class="form-control" value="{{ old('file') }}">
                            </div>
                            <div class="form-group mt-2">
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection