<tr>
    <td>{{$eventotag->id}}</td>
    <td>{{$eventotag->evento_id}}</td>
    <td>{{$eventotag->description }}</td>
    <td>{{$eventotag->tag_id}}</td>
    <td>{{$eventotag->tag_name}}</td>
    <td><a href="{{ route('cabinet.evento.eventotag.show',    $eventotag) }}" class="text-success" target="">{{ $eventotag->id }}</a></td>
    <td><a href="{{ route('cabinet.evento.eventotag.edit',    $eventotag) }}" class="text-warning" target="">{{ $eventotag->id }}</a></td>
    <td><a href="{{ route('cabinet.evento.eventotag.destroy', $eventotag) }}" class="text-danger" target="">{{ $eventotag->id }}</a></td>
</tr>