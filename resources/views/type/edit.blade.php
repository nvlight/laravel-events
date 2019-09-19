@extends('layouts.event')

@section('content')

    <a href="/category">Категории и типы событий</a>

    <?php
    //echo \App\Debug::d($category); die;
    ?>

    <div class="row">
        <div class="col-md-4">
            <h4>Редактирование типа события</h4>
            <h5 class="text-success"><?=session()->get('type_updated')?></h5>
            <form action="/type/{{$type->id}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="type-name">Имя</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="type-name" name="name" placeholder="компьютеры" value="{{$type->name}}" >
                </div>

                <div class="mb-3">
                    <label for="type-color">Цвет</label>
                    <input class="form-control {{ $errors->has('color') ? 'border-danger' : '' }}" id="type-color" name="color" placeholder="#ccc" value="{{$type->color}}" >
                </div>

                @include('errors')

                <div class="mb-3">
                    <button class="btn btn-success">Сохранить</button>
                </div>

            </form>

            <form class="" action="/type/{{$type->id}}" method="POST" style="">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit" title="удалить">
                    Удалить
                </button>
            </form>

        </div>
    </div>

@endsection