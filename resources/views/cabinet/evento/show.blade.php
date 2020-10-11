@extends('layouts.evento')

@section('content')
    <div class="container">
        <h2>Evento/Show</h2>
        <p><a href="{{ route('cabinet.evento.index') }}">Eventos</a></p>

        <table class="table table-bordered table-striped">
            @foreach($evento->attributesToArray() as $k => $v)
                <tr>
                    <th>{{ $k  }}</th>
                    <td>{{ $v }}</td>
                </tr>
            @endforeach
        </table>
        <div class="form-group mt-2">
            <a class="btn btn-" href="{{ route('cabinet.evento.edit', $evento) }}">Edit</a>
            <a class="btn btn-danger" href="{{ route('cabinet.evento.destroy', $evento) }}">Delete</a>
        </div>
    </div>
@endsection