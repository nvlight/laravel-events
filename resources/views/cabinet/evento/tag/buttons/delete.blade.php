@if($tagId)
<p>
    <a href="{{ route('cabinet.evento.tag.destroy', $tagId) }}"
       class="btn btn-success @if ($class) {{ $class  }} @endif">
        <span>delete</span>
    </a>
</p>
@endif