@extends('layouts.evento')

@section('content')
    <h2>Evento/EventoTag/Show</h2>
    @php
        //dd($eventotag);
    @endphp
    <table>
        @foreach($eventotag->attributesToArray() as $k => $v)
            <tr>
                <th>{{ $k  }}</th>
                <td>{{ $v }}</td>
            </tr>
        @endforeach
    </table>

@endsection