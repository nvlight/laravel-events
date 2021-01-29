@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <h2>Evento/Attachments/Create</h2>

                @include('cabinet.evento.attachment.nav.breadcrumbs')
                @include('cabinet.evento.attachment.buttons.create')

                @include('cabinet.evento._blocks.flash_message')

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cabinet.evento.attachment.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>
                                    <b>evento_id</b>
                                    <select name="evento_id" class="form-control w-100">
                                        <option>0</option>
                                        @foreach($eventos as $evento)
                                            <option value="{{ $evento->id }}">{{ $evento->description }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <b>file</b>
                                    <input type="file" name="file" class="form-control" value="{{ old('file') }}">
                                </label>
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