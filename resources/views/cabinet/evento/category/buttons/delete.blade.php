@if($categoryId)
<p>
    <a href="{{ route('cabinet.evento.category.destroy', $categoryId) }}"
       class="btn btn-success @if ($class) {{ $class  }} @endif">
        <span>delete</span>
    </a>
</p>
@endif