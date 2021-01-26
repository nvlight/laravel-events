<tr>
    <td>{{$eventocatetory->id}}</td>
    <td>{{$eventocatetory->evento_id}}</td>
    <td>{{$eventocatetory->description }}</td>
    <td>{{$eventocatetory->category_id}}</td>
    <td>{{$eventocatetory->category_name}}</td>
    <td><a href="{{ route('cabinet.evento.eventocategory.show',    $eventocatetory) }}" class="text-success" target="">{{ $eventocatetory->id }}</a></td>
    <td><a href="{{ route('cabinet.evento.eventocategory.edit',    $eventocatetory) }}" class="text-warning" target="">{{ $eventocatetory->id }}</a></td>
    <td><a href="{{ route('cabinet.evento.eventocategory.destroy', $eventocatetory) }}" class="text-danger" target="">{{ $eventocatetory->id }}</a></td>
</tr>