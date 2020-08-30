@extends('layouts.evento')

@section('content')
    <h2>Evento/Tag/Show</h2>

    @php
        //dump($tag);
        //dump($tag->attributesToArray());
    @endphp

    <table>
        @foreach($tag->attributesToArray() as $k => $v)
            <tr>
                <th>{{ $k  }}</th>
                <td>{{ $v }}</td>
            </tr>
        @endforeach
    </table>

@endsection