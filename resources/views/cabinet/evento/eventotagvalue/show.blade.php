@extends('layouts.evento')

@section('content')
    <h2>Evento/EventoTagValue/Show</h2>

    <table>
        @foreach($eventoTagValue->attributesToArray() as $k => $v)
            <tr>
                <th>{{ $k  }}</th>
                <td>{{ $v }}</td>
            </tr>
        @endforeach
    </table>

@endsection