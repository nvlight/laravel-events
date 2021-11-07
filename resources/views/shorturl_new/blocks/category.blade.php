@if (isset($item['id']) && isset($item['parent_id']) && isset($item['name']) )
    <div style="display: flex; align-items: center;" >
        <span>
            @php echo str_repeat($repeatStr, $offset) @endphp {{$item['id']}} {{$item['parent_id']}} {{$item['name']}}
        </span>
        <span>
            @include('shorturl_new.buttons.delete', ['item' => $item])
        </span>
    </div>
@endif