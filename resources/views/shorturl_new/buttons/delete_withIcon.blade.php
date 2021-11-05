<form action="{{ route('shorturl.destroy', $shorturl->id) }}" method="POST" class="shorturl-delete-button"  style="">
    @csrf
    @method('DELETE')
    <button class="mg-btn-1 " type="submit" title="удалить">
        <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
    </button>
</form>