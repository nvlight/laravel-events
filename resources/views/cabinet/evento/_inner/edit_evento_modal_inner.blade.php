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
        <div class="d-flex justify-content-between">
            <div>
                <button class="btn btn-success saveEditedEventoAjaxButton" type="submit">Save</button>
                <a class="btn btn-danger deleteShowedWithAjaxEventoButton" href="{{ route('cabinet.evento.destroy', $evento) }}">Delete</a>
                <a class="btn btn-primary editEventoCreateNewButton" href="{{ route('cabinet.evento.create') }}">New</a>
            </div>
            {{-- todo - удалить потом eventoEdit__successEditTagClassWrapper, должно работать и без него  --}}
            <div class="d-flex align-self-center eventoEdit__successEditTagClassWrapper spinMessage__wrapper eventoEdit__wrapper">
                <div class="d-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise align-self-center eventoEdit__successEditSpin d-none" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                    </svg>
                    <span class="ml-2 eventoEdit__successEditMessage d-none">
                        <span class="text-success d-none">Success!</span>
                        <span class="text-danger d-none">Fail!</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</form>