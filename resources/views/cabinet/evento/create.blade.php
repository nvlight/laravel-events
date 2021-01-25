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
                            @if(count($errors) > 0)
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger">{{ $error }}</div>
                                @endforeach
                            @endif

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

    {{-- todo this css/js for MDB - replace after --}}
{{--    <!-- Font Awesome -->--}}
{{--    <link href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"--}}
{{--        rel="stylesheet" />--}}
{{--    <!-- Google Fonts -->--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"--}}
{{--        rel="stylesheet" />--}}
{{--    <!-- MDB -->--}}
{{--    <link  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/2.2.1/mdb.min.css"--}}
{{--        rel="stylesheet" />--}}

{{--    <!-- MDB -->--}}
{{--    <script type="text/javascript"--}}
{{--        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/2.2.1/mdb.min.js">--}}
{{--    </script>--}}

@endsection