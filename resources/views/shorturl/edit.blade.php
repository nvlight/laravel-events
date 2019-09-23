@extends('layouts.event')

@section('content')

    <a href="/shorturl">Короткие ссылки</a>

    <?php
    //echo \App\Debug::d($category); die;
    ?>

    <div class="row">
        <div class="col-md-4">
            <h4>Редактирование короткой ссылки</h4>
            <h5 class="text-success"><?=session()->get('shorturl_updated')?></h5>
            <form action="/shorturl/{{$shorturl->id}}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="description">Описание</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="description" name="description" placeholder="Вика" value="{{$shorturl->description}}" >
                </div>

                <div class="mb-3">
                    <label for="longurl">Длинная ссылка</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="longurl" name="longurl" placeholder="https://laracasts.com/series/laravel-from-scratch-2018/episodes/28?autoplay=true" value="{{$shorturl->longurl}}" >
                </div>

                <div class="mb-3">
                    <label for="shorturl">Короткая ссылка</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="shorturl" name="shorturl" placeholder="https://our-site.net/su/UkOw3L" value="{{$shorturl->shorturl}}" >
                </div>

                @include('errors')

                <div class="mb-3">
                    <button class="btn btn-success">Сохранить</button>
                </div>

            </form>

            <form class="" action="/shorturl/{{$shorturl->id}}" method="POST" style="">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit" title="удалить">
                    Удалить
                </button>
            </form>

        </div>
    </div>

@endsection