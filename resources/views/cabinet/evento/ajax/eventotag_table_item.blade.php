@if($tag)

    {{-- tag_name / tag_value / eventotag_id / tag_color --}}

    <div class="eventoTagDiv" data-eventoTagId="{{ $tag['eventotag_id'] }}" data-tagId="{{ $tag['tag_id'] }}" >
        <button class="btn btn-primary btn-sm mb-2" style="background-color: {{$tag['tag_color']}}; border-color: {{$tag['tag_color']}};">
            <span class="eventotag_name">{{ $tag['tag_name'] }}</span>
            @if (isset($tag['tag_value']))
                <span class="badge rounded-pill bg-secondary">{{ $tag['tag_value'] }}</span>
            @endif
        </button>
        <a href="{{ route('cabinet.evento.eventotag.destroy', $tag['eventotag_id']) }}"
           class="delete_tag" data-tagId="{{ $tag['eventotag_id'] }}">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg" role="button">
                <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
            </svg>
        </a>
    </div>

@endif