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

    <td><a href="{{ route('cabinet.evento.eventotagvalue.show',    $eventoTagValue->evento_evento_tag_values_id) }}" class="text-success" target="">{{ $eventoTagValue->evento_evento_tag_value_value }}</a></td>
    <td><a href="{{ route('cabinet.evento.eventotagvalue.edit',    $eventoTagValue->evento_evento_tag_values_id) }}" class="text-warning" target="">{{ $eventoTagValue->evento_evento_tag_value_value }}</a></td>
    <td><a href="{{ route('cabinet.evento.eventotagvalue.destroy', $eventoTagValue->evento_evento_tag_values_id) }}" class="text-danger" target="">{{ $eventoTagValue->evento_evento_tag_value_value }}</a></td>
</tr>