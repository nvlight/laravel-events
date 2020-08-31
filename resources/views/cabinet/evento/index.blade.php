@extends('layouts.evento')

@section('content')
    <h2>Evento/index</h2>
    <p><a href="{{ route('cabinet.evento.create') }}">create new evento</a></p>
    <p><a href="{{ route('cabinet.evento.category.index') }}">category index</a></p>
    <p><a href="{{ route('cabinet.evento.tag.index') }}">tag index</a></p>

    @if($eventos)
        <table>
            <tr>
                <th>id</th>
                <th>description</th>
                <th>date</th>
                <th>show</th>
                <th>delete</th>
                <th>update</th>
            </tr>
        @foreach($eventos as $evento)
            <tr>
                <td>{{$evento->id}}</td>
                <td>{{$evento->description}}</td>
                <td>{{$evento->date}}</td>
                <td><a href="{{ route('cabinet.evento.show',    $evento) }}" target="">{{ $evento->description }}</a></td>
                <td><a href="{{ route('cabinet.evento.destroy', $evento) }}" target="">{{ $evento->description }}</a></td>
                <td><a href="{{ route('cabinet.evento.edit',    $evento) }}" target="">{{ $evento->description }}</a></td>
            </tr>
        @endforeach
        </table>
    @endif

@endsection