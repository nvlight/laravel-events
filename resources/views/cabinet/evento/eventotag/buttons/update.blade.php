@if($itemId)
<p>
    <a href="{{ route('cabinet.evento.eventotag.edit', $itemId) }}"
       class="btn btn-success @if ($class) {{ $class  }} @endif">
        <span>update</span>
    </a>
</p>
@endif