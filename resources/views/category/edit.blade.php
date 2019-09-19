@extends('layouts.event')

@section('content')

    <a href="/category">Категории и типы событий</a>

    <?php
    //echo \App\Debug::d($category); die;
    ?>

    <div class="row">
        <div class="col-md-4">
            <h4>Редактирование категории события</h4>
            <h5 class="text-success"><?=session()->get('category_updated')?></h5>
            <form action="/category/{{$category->id}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="category-name">Имя</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="category-name" name="name" placeholder="компьютеры" value="{{$category->name}}" >
                </div>

                @include('errors')

                <div class="mb-3">
                    <button class="btn btn-success">Сохранить</button>
                </div>

            </form>

            <form class="" action="/category/{{$category->id}}" method="POST" style="">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit" title="удалить">
                    Удалить
                </button>
            </form>

        </div>
    </div>

@endsection