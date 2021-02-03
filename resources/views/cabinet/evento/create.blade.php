@extends('layouts.evento')

@section('content')
    <div class="container">
        <h2>Evento/Create</h2>

        @include('cabinet.evento.category.nav.breadcrumbs')

        <div class="row">
            <div class="col-md-4">

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            @include('cabinet.evento._blocks.flash_message')

                            <form action="{{ route('cabinet.evento.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="description"><b>description:</b></label>
                                    <input type="text" id="description" name="description" class="form-control" value="{{ old('description') }}">
                                </div>
                                <div class="form-group">
                                    <label for="date"><b>date:</b></label>
                                    <input type="text" id="date" name="date" class="form-control" value="{{ old('date') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <button class="btn btn-success" type="submit">Save</button>
                                </div>
                            </form>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection