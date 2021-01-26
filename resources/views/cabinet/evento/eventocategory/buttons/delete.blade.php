@if($eventoCategoryId)
<p>
    <a href="{{ route('cabinet.evento.eventocategory.destroy', $eventoCategoryId) }}"
       class="btn btn-success @if ($class) {{ $class  }} @endif">
        <span>delete</span>
    </a>
</p>
@endif