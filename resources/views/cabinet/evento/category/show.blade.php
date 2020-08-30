@extends('layouts.evento')

@section('content')
    <h2>Evento/Category/Show</h2>

    @php
        //dump($category);
        //dump($category->attributesToArray());
    @endphp

    <table>
        @foreach($category->attributesToArray() as $k => $v)
            <tr>
                <th>{{ $k  }}</th>
                <td>{{ $v }}</td>
            </tr>
        @endforeach
    </table>

@endsection