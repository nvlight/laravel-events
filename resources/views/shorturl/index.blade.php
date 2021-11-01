@extends('layouts.event')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-3">Короткие ссылки</h2>
            <a href="{{ route('event.index') }}">Главная</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h4>Добавить короткую ссылку</h4>
            <form action="{{ route('shorturl.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="description">Описание</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="description" name="description" placeholder="Описания для очень полезной ссылки, ага!" value="{{old('description')}}" >
                </div>

                <div class="mb-3">
                    <label for="longurl">Длинная ссылка</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="longurl" name="longurl" placeholder="https://laracasts.com/series/laravel-from-scratch-2018/episodes/28?autoplay=true" value="{{old('longurl')}}" >
                </div>

                @include('errors')

                <div class="mb-3">
                    <button class="btn btn-success">Создать</button>
                </div>

            </form>
        </div>

        <div class="col-md-6">
            <h4>Поиск короткой ссылки</h4>
            <form action="{{ route('shorturl.index') }}" method="GET">

                <div class="mb-3">
                    <label for="description2">Описание</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="description2" name="description" placeholder="Описание самой крутой ссылки, ага!" value="{{$description}}" >
                </div>

                @include('errors')

                <div class="mb-3">
                    <button class="btn btn-success">Искать</button>
                    <a href="{{ route('shorturl.index') }}" class="btn btn-danger">Сброс</a>
                </div>

            </form>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12">
            <h4>Список коротких ссылок</h4>
            <h5 class="text-success"><?=session()->get('shorturl_deleted')?></h5>
            <h5 class="text-success"><?=session()->get('shorturl_created')?></h5>
            <h5 class="text-success"><?=session()->get('shorturl_updated')?></h5>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>№</th>
                    <th>Описание</th>
                    <th>Длинная ссылка</th>
                    <th>Короткая ссылка</th>
                    <th>actions</th>
                </tr>

                @include('shorturl.table-data')

            </table>

            {{$shorturls->links()}}

        </div>

    </div>

@endsection