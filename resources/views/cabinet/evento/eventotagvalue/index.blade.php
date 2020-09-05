@extends('layouts.evento')

@section('content')
    <h2>Evento/EventoTagValue/index</h2>
    <p><a href="{{ route('cabinet.evento.eventotagvalue.create') }}">eventoTagValue create</a></p>

    @if($eventoTagValues)
        <table>
            <tr>
                <th>evento_id</th>
                <th>evento_description</th>
                <th>evento_date</th>
                <th>tag_id</th>
                <th>tag_name</th>
                <th>ee_tag_id</th>
                <th>eetv_id</th>
                <th>eetv_value</th>
                <th>eetv_caption</th>

                <th>show</th>
                <th>delete</th>
                <th>update</th>
            </tr>
            @foreach($eventoTagValues as $eventoTagValue)
                <tr>
                    <td>{{$eventoTagValue->evento_id}}</td>
                    <td>{{$eventoTagValue->evento_description}}</td>
                    <td>{{$eventoTagValue->evento_date}}</td>
                    <td>{{$eventoTagValue->tag_id}}</td>
                    <td>{{$eventoTagValue->tag_name}}</td>
                    <td>{{$eventoTagValue->evento_evento_tag_id}}</td>
                    <td>{{$eventoTagValue->evento_evento_tag_values_id}}</td>
                    <td>{{$eventoTagValue->evento_evento_tag_value_value}}</td>
                    <td>{{$eventoTagValue->evento_evento_tag_value_caption}}</td>
                    <td><a href="{{ route('cabinet.evento.eventotagvalue.show',    $eventoTagValue->evento_evento_tag_values_id) }}" target="">{{ $eventoTagValue->evento_evento_tag_value_value }}</a></td>
                    <td><a href="{{ route('cabinet.evento.eventotagvalue.destroy', $eventoTagValue->evento_evento_tag_values_id) }}" target="">{{ $eventoTagValue->evento_evento_tag_value_value }}</a></td>
                    <td><a href="{{ route('cabinet.evento.eventotagvalue.edit',    $eventoTagValue->evento_evento_tag_values_id) }}" target="">{{ $eventoTagValue->evento_evento_tag_value_value }}</a></td>
                </tr>
            @endforeach
        </table>
    @endif

@endsection