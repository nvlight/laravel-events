<form action="{{ route('cabinet.evento.update_ajax', $evento) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="description"><b>description:</b></label>
        <textarea type="text" id="description" name="description" class="form-control">{{ $evento->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="date"><b>date:</b></label>
        <input type="text" id="date" name="date" class="form-control flatpickrEventoEditDate" value="{{ $evento->date }}">
    </div>
    <div class="form-group mt-2">
        <button class="btn btn-success saveEditedEventoAjaxButton" type="submit">Save</button>
        <a class="btn btn-danger deleteShowedWithAjaxEventoButton" href="{{ route('cabinet.evento.destroy', $evento) }}">Delete</a>
        <a class="btn btn-primary editEventoCreateNewButton" href="{{ route('cabinet.evento.create') }}">New</a>
    </div>
</form>