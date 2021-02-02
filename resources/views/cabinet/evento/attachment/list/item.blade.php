<tr>
    <td>{{$attachment->id}}</td>
    <td>{{$attachment->user_id}}</td>
    <td>{{$attachment->evento_id}}</td>
    <td>{{$attachment->file}}</td>
    <td>{{$attachment->originalname}}</td>
    <td><a href="{{ route('cabinet.evento.attachment.show',    $attachment) }}" class="btn btn-primary btn-sm" target="">show</a></td>
    <td><a href="{{ route('cabinet.evento.attachment.edit',    $attachment) }}" class="btn btn-warning btn-sm" target="">edit</a></td>
    <td><a href="{{ route('cabinet.evento.attachment.destroyAndRedirect', $attachment) }}" class="btn btn-danger btn-sm" target="">delete</a></td>
    <td><a href="{{ route('cabinet.evento.attachment.download',$attachment) }}" class="btn btn-dark btn-sm" target="">download</a></td>
</tr>