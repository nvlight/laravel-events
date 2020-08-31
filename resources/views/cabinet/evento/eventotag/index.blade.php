@extends('layouts.evento')

@section('content')
    <h2>Evento/EventoTag/index</h2>
    <p><a href="{{ route('cabinet.evento.eventotag.create') }}">create new evento-tag</a></p>

    @if($eventotags)
        <table>
            <tr>
                <th>id</th>
                <th>evento_id</th>
                <th>evento_caption</th>
                <th>tag_id</th>
                <th>tag_name</th>
                <th>show</th>
                <th>delete</th>
                <th>update</th>
            </tr>
            @foreach($eventotags as $eventotag)
                <tr>
                    <td>{{$eventotag->id}}</td>
                    <td>{{$eventotag->evento_id}}</td>
                    <td>{{ $eventotag->description }}</td>
                    <td>{{$eventotag->tag_id}}</td>
                    <td>{{$eventotag->tag_name}}</td>
                    <td><a href="{{ route('cabinet.evento.eventotag.show',    $eventotag) }}" target="">{{ $eventotag->id }}</a></td>
                    <td><a href="{{ route('cabinet.evento.eventotag.destroy', $eventotag) }}" target="">{{ $eventotag->id }}</a></td>
                    <td><a href="{{ route('cabinet.evento.eventotag.edit',    $eventotag) }}" target="">{{ $eventotag->id }}</a></td>
                </tr>
            @endforeach
        </table>
    @endif

@endsection