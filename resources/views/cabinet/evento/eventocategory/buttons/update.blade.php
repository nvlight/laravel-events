@if($eventoCategoryId)
<p>
    <a href="{{ route('cabinet.evento.eventocategory.edit', $eventoCategoryId) }}"
       class="btn btn-success @if ($class) {{ $class  }} @endif">
        <span>update</span>
    </a>
</p>
@endif