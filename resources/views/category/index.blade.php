@extends('layouts.event')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-3">Категории и типы событий</h2>
            <a href="/event">Список событий</a>
        </div>
    </div>

    <?php
    $mg_errors3 = '';
    $mg_errors =  ($errors);
    //echo \App\Debug::d($mg_errors);
    if (is_array($mg_errors)){
        $mg_errors2 = array_keys($mg_errors);
        $mg_errors3 = implode(';', $mg_errors2);
        //echo \App\Debug::d($mg_errors3);
        //echo \App\Debug::d(preg_match("#^category#ui",$mg_errors3));
    }
    //echo \App\Debug::d(old());
    //echo \App\Debug::d(old('type-color'));
    ?>

    <div class="row">
        <div class="col-md-6">
            <h4>Добавить категорию события</h4>
            <form action="/category" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="category-name">Имя</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="category-name" name="name" placeholder="компьютеры" value="{{old('name')}}" >
                </div>

                @include('errors')

                <div class="mb-3">
                    <button class="btn btn-success">Создать</button>
                </div>

            </form>
        </div>
        <div class="col-md-6">
            <h4>Добавить тип события</h4>
            <form action="/type" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="type-name">Имя</label>
                    <input class="form-control  {{ $errors->has('name') ? 'border-danger' : '' }}" id="type-name" name="name" placeholder="выходной" value="{{old('name')}}" >
                </div>

                <div class="mb-3">
                    <label for="type-color">Цвет</label>
                    <input class="form-control {{ $errors->has('color') ? 'border-danger' : '' }}" id="type-color" name="color" placeholder="79B1E1" value="{{old('color')}}" >
                </div>

                @include('errors')

                <div class="mb-3">
                    <button class="btn btn-success">Создать</button>
                </div>

            </form>

        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <h4>Список категорий событий</h4>
            <h5 class="text-success"><?=session()->get('category_created')?></h5>
            <h5 class="text-success"><?=session()->get('category_updated')?></h5>
            <h5 class="text-success"><?=session()->get('category_deleted')?></h5>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>№</th>
                    <th>Имя</th>
                    <th>actions</th>
                </tr>
                @if($categories->count())
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td class="td-btn-flex-1">
                                <form action="/category/{{$category->id}}/edit" method="GET" style="">
                                    <button class="mg-btn-1" type="submit" title="редактировать">
                                        <svg height="22" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true" class="mg-btn-edit"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
                                    </button>
                                </form>

                                <form action="/category/{{$category->id}}" method="POST" style="">
                                    @csrf
                                    @method('DELETE')
                                    <button class="mg-btn-1" type="submit" title="удалить">
                                        <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="">Список пуст</td>
                    </tr>
                @endif
            </table>

        </div>



        <div class="col-md-6">
            <h4>Список типов событий</h4>
            <h5 class="text-success"><?=session()->get('type_created')?></h5>
            <h5 class="text-success"><?=session()->get('type_updated')?></h5>
            <h5 class="text-success"><?=session()->get('type_deleted')?></h5>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>№</th>
                    <th>Имя</th>
                    <th>Цвет</th>
                    <th>actions</th>
                </tr>
                @if($types->count())
                    @foreach($types as $type)
                        <tr>
                            <td>{{$type->id}}</td>
                            <td>{{$type->name}}</td>
                            <td class="">
                                <div class="event_type_td">
                                    {{$type->color}}<span class="event_type_color" style="background-color: #{{$type->color}};"></span>
                                </div>
                            </td>
                            <td class="td-btn-flex-1">
                                <form action="/type/{{$type->id}}/edit" method="GET" style="">
                                    <button class="mg-btn-1" type="submit" title="редактировать">
                                        <svg height="22" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true" class="mg-btn-edit"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
                                    </button>
                                </form>

                                <form action="/type/{{$type->id}}" method="POST" style="">
                                    @csrf
                                    @method('DELETE')
                                    <button class="mg-btn-1" type="submit" title="удалить">
                                        <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="">Список пуст</td>
                    </tr>
                @endif
            </table>

        </div>
    </div>

@endsection