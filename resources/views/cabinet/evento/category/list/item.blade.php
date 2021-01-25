<tr>
    <td>{{$category->id}}</td>
    <td>{{$category->parent_id}}</td>
    <td>{{$category->name}}</td>
    <td>{{$category->img}}</td>
    <td><a href="{{ route('cabinet.evento.category.show',   $category) }}" class="text-success" target="">{{ $category->name }}</a></td>
    <td><a href="{{ route('cabinet.evento.category.edit', $category) }}" class="text-warning" target="">{{ $category->name }}</a></td>
    <td><a href="{{ route('cabinet.evento.category.destroy', $category) }}" class="text-danger" target="">{{ $category->name }}</a></td>
</tr>