@extends('layouts.evento')

@section('content')
    <h2>Evento/index</h2>
    <p><a href="{{ route('cabinet.evento.create') }}">create new evento</a></p>
    <p><a href="{{ route('cabinet.evento.category.index') }}">category index</a></p>
    <p><a href="{{ route('cabinet.evento.tag.index') }}">tag index</a></p>
    <p><a href="{{ route('cabinet.evento.eventocategory.index') }}">eventoCategory index</a></p>
    <p><a href="{{ route('cabinet.evento.eventotag.index') }}">eventoTag index</a></p>
    <p><a href="{{ route('cabinet.evento.eventotagvalue.index') }}">eventoTagValue index</a></p>

    <p><a href="{{ route('cabinet.evento.attachment.index') }}">attachment index</a></p>

    <style>
        table{
            border: 1px solid #000;
            border-collapse: collapse;
        }
        table tr th, table tr td{
            border: 1px solid #000;
        }
    </style>

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

                    <td><a href="{{ route('cabinet.evento.show',    $evento ) }}">show </a></td>
                    <td><a href="{{ route('cabinet.evento.destroy', $evento ) }}">delete </a></td>
                    <td><a href="{{ route('cabinet.evento.edit',    $evento ) }}">update </a></td>
                </tr>
            @endforeach
        </table>
    @endif

    @if($eventosWithAllColumns)

        <table>
            <tr>
                <th>e_id</th>
                <th>e_description</th>
                <th>e_date</th>
                <th>e_cat_id</th>
                <th>e_category_name</th>
                <th>ee_cat_id</th>
                <th>e_tag_id</th>
                <th>e_tag_name</th>
                <th>ee_tag_id</th>
                <th>ee_tv_id</th>
                <th>ee_tv_val</th>
                <th>ee_tv_cap</th>

                <th>show</th>
                <th>delete</th>
                <th>update</th>
            </tr>
        @foreach($eventosWithAllColumns as $eventoWithAllColumns)
            <tr>
                <td>{{$eventoWithAllColumns->evento_id}}</td>
                <td>{{$eventoWithAllColumns->evento_description}}</td>
                <td>{{$eventoWithAllColumns->evento_date}}</td>
                <td>{{$eventoWithAllColumns->evento_category_id}}</td>
                <td>{{$eventoWithAllColumns->evento_category_name}}</td>
                <td>{{$eventoWithAllColumns->evento_evento_category_id}}</td>
                <td>{{$eventoWithAllColumns->evento_tag_id}}</td>
                <td>{{$eventoWithAllColumns->evento_tag_name}}</td>
                <td>{{$eventoWithAllColumns->evento_evento_tag_id}}</td>
                <td>{{$eventoWithAllColumns->evento_evento_tag_values_id}}</td>
                <td>{{$eventoWithAllColumns->evento_evento_tag_value_value}}</td>
                <td>{{$eventoWithAllColumns->evento_evento_tag_value_caption}}</td>

                <td><a href="{{ route('cabinet.evento.show',    $eventoWithAllColumns->evento_id) }}">show </a></td>
                <td><a href="{{ route('cabinet.evento.destroy', $eventoWithAllColumns->evento_id) }}">delete </a></td>
                <td><a href="{{ route('cabinet.evento.edit',    $eventoWithAllColumns->evento_id) }}">update </a></td>
            </tr>
        @endforeach
        </table>
    @endif

@endsection