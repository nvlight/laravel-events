@extends('layouts.evento')

@section('content')
    <h2>Evento/Attachments/index</h2>
    <p><a href="{{ route('cabinet.evento.attachment.create') }}">create new attachment</a></p>

    @if($attachments)
        <table>
            <tr>
                <th>id</th>
                <th>user_id</th>
                <th>evento_id</th>
                <th>file</th>
                <th>orig_name</th>
                <th>show</th>
                <th>delete</th>
                <th>update</th>
            </tr>
            @foreach($attachments as $attachment)
                <tr>
                    <td>{{$attachment->id}}</td>
                    <td>{{$attachment->user_id}}</td>
                    <td>{{$attachment->evento_id}}</td>
                    <td>{{$attachment->file}}</td>
                    <td>{{$attachment->originalname}}</td>
                    <td><a href="{{ route('cabinet.evento.attachment.show',    $attachment) }}" target="">show</a></td>
                    <td><a href="{{ route('cabinet.evento.attachment.destroy', $attachment) }}" target="">delete</a></td>
                    <td><a href="{{ route('cabinet.evento.attachment.edit',    $attachment) }}" target="">edit</a></td>
                    <td><a href="{{ route('cabinet.evento.attachment.download',$attachment) }}" target="">download</a></td>
                </tr>
            @endforeach
        </table>
    @endif

@endsection