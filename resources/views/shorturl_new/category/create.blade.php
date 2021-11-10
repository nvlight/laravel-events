@extends('layouts.event')

@section('content')

    <a href="{{ route('shorturlnew.index') }}">Короткие ссылки</a>

    <div class="row">
        <div class="col-md-4">
            <h4>Создание категории</h4>

            <div class="actions">

                <form action="{{ route('shorturlnew.store') }}" method="POST">
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