@if($itemId)
<p>
    <a href="{{ route('cabinet.evento.eventotag.destroy', $itemId) }}"
       class="btn btn-success @if ($class) {{ $class  }} @endif">
        <span>delete</span>
    </a>
</p>
@endif