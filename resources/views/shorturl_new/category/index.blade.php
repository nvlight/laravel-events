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
            <h4>Список коротких ссылок</h4>
            <h5 class="text-success"><?=session()->get('shorturlnew_deleted')?></h5>
            <h5 class="text-success"><?=session()->get('shorturl_updated')?></h5>

            <div>
                @include('shorturl_new.category.table-data')
            </div>

        </div>
        <div class="col-md-6">

            <h4>Создание категории</h4>
            <h5 class="text-success"><?=session()->get('shorturlnew_category_created')?></h5>
            <div class="actions">
                <form action="{{ route('shorturlnew_category.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="parent_id">Выбор каталога</label>
                        <select class="form-control" name="parent_id" id="parent_id">
                            <option value="0">Корневой каталог</option>
                            @if( count($shortUrlIds) )
                                @foreach($shortUrlIds as $k => $v)
                                    <option value="{{$k}}">{{$v}}</option>
                                @endforeach
                            @endif
                        </select>
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