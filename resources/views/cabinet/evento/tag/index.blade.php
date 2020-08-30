@extends('layouts.evento')

@section('content')
    <h2>Evento/Tag/index</h2>

    @if($tags)

        @if (\Session::has('event_tag_deleted'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ \Session::get('event_tag_deleted') }}</li>
                </ul>
            </div>
        @endif

        <table>
            <tr>
                <th>name</th>
                <th>color</th>
                <th>img</th>
                <th>show</th>
                <th>delete</th>
                <th>update</th>
            </tr>
        @foreach($tags as $tag)
            <tr>
                <td>{{$tag->name}}</td>
                <td>{{$tag->color}}</td>
                <td>{{$tag->img}}</td>
                <td><a href="{{ route('cabinet.evento.tag.show',   $tag) }}"  target="">{{ $tag->name }}</a></td>
                <td><a href="{{ route('cabinet.evento.tag.destroy', $tag) }}" target="">{{ $tag->name }}</a></td>
                <td><a href="{{ route('cabinet.evento.tag.edit', $tag) }}" target="">{{ $tag->name }}</a></td>
            </tr>
        @endforeach
        </table>
    @endif

@endsection