@if($itemId)
<p>
    <a href="{{ route('cabinet.evento.eventotagvalue.destroy', $itemId) }}"
       class="btn btn-success @if ($class) {{ $class  }} @endif">
        <span>delete</span>
    </a>
</p>
@endif