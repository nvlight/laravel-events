@extends('layouts.event')

@section('content')

    <a href="{{ route('shorturl.index') }}">Короткие ссылки</a>

    <div class="row">
        <div class="col-md-4">
            <h4>Редактирование короткой ссылки</h4>
            <h5 class="text-success"><?=session()->get('shorturl_updated')?></h5>

            <div class="actions">

                <form action="{{ route('shorturl.update', $shorturl->id) }}" method="POST">
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
                    @include('shorturl.buttons.save')

                </form>


            </div>

            <div class="mt-3">
                @include('shorturl.buttons.delete_withText')
            </div>
        </div>
    </div>

@endsection