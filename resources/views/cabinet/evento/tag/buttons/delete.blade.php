@if($itemId)
    <p>
        <a href="{{ route('cabinet.evento.tag.destroy', $itemId) }}"
           class="btn btn-success @if ($class) {{ $class  }} @endif">
            <span>delete</span>
        </a>
    </p>
@endif