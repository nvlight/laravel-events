@extends('layouts.evento')

@section('content')
    <h2>Evento/Attachment/Show</h2>

    <table>
        @foreach($attachment->attributesToArray() as $k => $v)
            <tr>
                <th>{{ $k  }}</th>
                <td>{{ $v }}</td>
            </tr>
        @endforeach
    </table>

@endsection