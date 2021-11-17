@extends('layouts.event')

@section('content')

    <a href="{{ route('shorturlnew_category.index') }}">Короткие ссылки</a>

    <div class="row">
        <div class="col-md-4">
            <h4>Создание категории</h4>

            <div class="actions">

                <form action="{{ route('shorturlnew_category.storeWithParent') }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                    <div class="mb-3">
                        <label for="parent_id_disabled">Категория родитель</label>
                        <input class="form-control" name="parent_id_disabled" id="parent_id_disabled"
                               value="{{ $parent->id }} {{ $parent->name }}" disabled >
                    </div>

                    <div class="mb-3">
                        <label for="name">Введите имя каталога</label>
                        <input class="form-control " id="name" name="name" placeholder="интересный каталог" value="" >
                    </div>

                    @include('errors')
                    @include('shorturl_new.buttons.save')

                </form>

            </div>

        </div>
    </div>

@endsection