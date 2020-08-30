@extends('layouts.evento')

@section('content')
    <h2>Evento/Category/index</h2>
    <p><a href="{{ route('cabinet.evento.category.create') }}">create new</a></p>

    @if($categories)
        <table>
            <tr>
                <th>parent_id</th>
                <th>name</th>
                <th>img</th>
                <th>show</th>
                <th>delete</th>
                <th>update</th>
            </tr>
        @foreach($categories as $category)
            <tr>
                <td>{{$category->parent_id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->img}}</td>
                <td><a href="{{ route('cabinet.evento.category.show',   $category) }}"  target="">{{ $category->name }}</a></td>
                <td><a href="{{ route('cabinet.evento.category.destroy', $category) }}" target="">{{ $category->name }}</a></td>
                <td><a href="{{ route('cabinet.evento.category.edit', $category) }}" target="">{{ $category->name }}</a></td>
            </tr>
        @endforeach
        </table>
    @endif

@endsection