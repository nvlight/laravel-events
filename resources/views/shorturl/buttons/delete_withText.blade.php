<form action="{{ route('shorturl.destroy', $shorturl->id) }}" method="POST" >
    @csrf
    @method('DELETE')
    <button class="btn btn-danger" style="margin-left: 3px;" type="submit" title="удалить">
        Удалить
    </button>
</form>