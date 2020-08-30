@extends('layouts.evento')

@section('content')
    <h2>Evento/Show</h2>

    <table>
        @foreach($evento->attributesToArray() as $k => $v)
            <tr>
                <th>{{ $k  }}</th>
                <td>{{ $v }}</td>
            </tr>
        @endforeach
    </table>

@endsection