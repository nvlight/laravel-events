@extends('layouts.evento')

@section('content')
    <h2>Evento/EventoCategory/index</h2>
    <p><a href="{{ route('cabinet.evento.eventocategory.create') }}">create new evento-category</a></p>

    @if($eventocategories)
        <table>
            <tr>
                <th>id</th>
                <th>evento_id</th>
                <th>evento_caption</th>
                <th>category_id</th>
                <th>category_name</th>
                <th>show</th>
                <th>delete</th>
                <th>update</th>
            </tr>
            @foreach($eventocategories as $eventocatetory)
                <tr>
                    <td>{{$eventocatetory->id}}</td>
                    <td>{{$eventocatetory->evento_id}}</td>
                    <td>{{ $eventocatetory->description }}</td>
                    <td>{{$eventocatetory->category_id}}</td>
                    <td>{{$eventocatetory->category_name}}</td>
                    <td><a href="{{ route('cabinet.evento.eventocategory.show',    $eventocatetory) }}" target="">{{ $eventocatetory->id }}</a></td>
                    <td><a href="{{ route('cabinet.evento.eventocategory.destroy', $eventocatetory) }}" target="">{{ $eventocatetory->id }}</a></td>
                    <td><a href="{{ route('cabinet.evento.eventocategory.edit',    $eventocatetory) }}" target="">{{ $eventocatetory->id }}</a></td>
                </tr>
            @endforeach
        </table>
    @endif

@endsection