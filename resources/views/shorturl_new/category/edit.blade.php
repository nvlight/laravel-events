@extends('layouts.event')

@section('content')

    <a href="{{ route('shorturlnew_category.index') }}">Короткие ссылки</a>

    <div class="row">
        <div class="col-md-4">
            <h4>Редактирование короткой ссылки</h4>
            <h5 class="text-success"><?=session()->get('shorturlnew_category_updated')?></h5>

            <div class="actions">

                <form action="{{ route('shorturlnew_category.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="id">id</label>
                        <input class="form-control" id="id" name="id" placeholder="Вика" value="{{$category->id}}" disabled="" >
                    </div>

                    <div class="mb-3">
                        <label for="parent_id">parent_id</label>
                        <input class="form-control" id="parent_id" name="parent_id" placeholder="Вика" value="{{$category->parent_id}}" >
                    </div>

                    <div class="mb-3">
                        <label for="name">name</label>
                        <input class="form-control" id="name" name="name" value="{{$category->name}}"
                               placeholder="https://laracasts.com/series/laravel-from-scratch-2018/episodes/28?autoplay=true">
                    </div>

                    @include('errors')

                    @include('shorturl.buttons.save')

                </form>

                <div class="actions" style="display: flex; ">
                        <span style="display: flex;">
                            @include('shorturl_new.buttons.view', ['item' => $category])
                            @include('shorturl_new.buttons.delete', ['item' => $category])
                        </span>
                </div>

            </div>
        </div>
    </div>

@endsection