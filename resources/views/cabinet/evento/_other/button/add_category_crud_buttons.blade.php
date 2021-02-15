<div class="add-category-crud--buttons @if (isset($class)) {{ $class }} @endif" style="@if (isset($style)) {{ $style }} @endif">
    @if ($confirmButton) {!!  $confirmButton !!} @endif
    @if ($cancelButton)  {!!  $cancelButton  !!} @endif
</div>