@extends('layouts.evento')

@section('content')
    <h2>Evento/EventoCategory/Show</h2>

    <table>
        @foreach($eventocategory->attributesToArray() as $k => $v)
            <tr>
                <th>{{ $k }}</th>
                <td>{{ $v }}</td>
            </tr>
        @endforeach
    </table>

@endsection