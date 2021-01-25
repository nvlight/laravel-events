<tr>
    <td>{{$tag->id}}</td>
    <td>{{$tag->name}}</td>
    <td>{{$tag->color}}</td>
    <td>{{$tag->img}}</td>
    <td><a href="{{ route('cabinet.evento.tag.show',   $tag) }}" class="text-success" target="">{{ $tag->name }}</a></td>
    <td><a href="{{ route('cabinet.evento.tag.edit', $tag) }}" class="text-warning" target="">{{ $tag->name }}</a></td>
    <td><a href="{{ route('cabinet.evento.tag.destroy', $tag) }}" class="text-danger" target="">{{ $tag->name }}</a></td>
</tr>