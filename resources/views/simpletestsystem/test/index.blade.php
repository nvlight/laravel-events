@extends('layouts.event')

@section('content')

    <h3 class="mb-3">Простая тестовая система</h3>

    <div class="row">
        <div class="col-sm-6">
            <h5>Добавление категории</h5>
            <form action="/simple-test-system" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="parent_id">Родительская категория</label>
{{--                    <input class="form-control {{ $errors->has('parent_id') ? 'border-danger' : '' }}" id="parent_id" name="parent_id" placeholder="Описания для очень полезной ссылки, ага!" value="0" >--}}
                    <select class="form-control" name="parent_id" id="parent_id">
                        <option value="0">Корень</option>
                        @if($categories->count())
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name">Название</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="name" name="name" placeholder="" value="{{old('name')}}" >
                </div>

                @include('errors')

                <div class="mb-3">
                    <button class="btn btn-success">Создать</button>
                </div>

            </form>
        </div>

        <div class="col-sm-6">
            <h5>Добавление теста (банка ТЗ)</h5>
            <form action="/simple-test-system-test" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tparent_id">Родительская категория</label>
                    <select class="form-control" name="parent_id" id="tparent_id">
                        <option value="0">Не выбрано</option>
                        @if($categories->count())
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tname">Название</label>
                    <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="tname" name="name" placeholder="" value="{{old('name')}}" >
                </div>

                @include('errors')

                <div class="mb-3">
                    <button class="btn btn-success">Создать</button>
                </div>
            </form>
        </div>


    </div>

    <div class="row">

        <?php

        ?>
        <div class="col-sm-6">
            <h5>Категории тестов</h5>
            <h5 class="text-success"><?=session()->get('testcategory_created')?></h5>
            <h5 class="text-success"><?=session()->get('testcategory_deleted')?></h5>

            <table class="table table-bordered table-striped">
                <tr>
                    <th>#</th>
                    <th>Родительская категория</th>
                    <th>Имя</th>
                    <th>Действия</th>
                </tr>
                @if($categories->count())
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>
                                @if($category->parent_id === 0)
                                    Корень
                                @else
                                    <?php
                                    $curr_parent_id = $category->parent_id;
                                    //dd($curr_parent_id);
                                    $cat_parent_name = $categories->filter(function($item) use ($curr_parent_id) {
                                        //dd($curr_parent_id);
                                        //echo 'itemId: ' . $item->id  . ' parentId: ' . $curr_parent_id ;
                                        $rs = $item->id == $curr_parent_id;
                                        //dd($item->id);
                                        //echo $rs;
                                        return $rs;
                                    })->first();
                                    //dd($rs);
                                    //echo \App\Debug::d($rs,'',2);
                                    ?>
                                    @if($cat_parent_name !== null)
                                        {{$cat_parent_name->name}}
{{--                                            - {{$category->parent_id}}--}}
                                    @else
                                        null - {{$category->parent_id}}
                                    @endif

                                @endif
                            </td>

                            <td>{{$category->name}}</td>
                            <td class="td-btn-flex-1">
                                <form action="/simple-test-system/{{$category->id}}/edit" method="GET" style="">
                                    <button class="mg-btn-1" type="submit" title="редактировать">
                                        <a href="/simple-test-system/{{$category->id}}/edit">
                                            <svg height="22" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true" class="mg-btn-edit"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
                                        </a>
                                    </button>
                                </form>

                                <form action="/simple-test-system/{{$category->id}}" class="shorturl-delete-button" method="POST" style="">
                                    @csrf
                                    @method('DELETE')
                                    <button class="mg-btn-1 " type="submit" title="удалить">
                                        <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                @endif
            </table>


        </div>

        <div class="col-sm-6">
            <h5>Список тестов (ТЗ)</h5>
            <h5 class="text-success"><?=session()->get('test_created')?></h5>
            <h5 class="text-success"><?=session()->get('test_deleted')?></h5>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>#</th>
                    <th>Родительская категория</th>
                    <th>Имя</th>
                    <th>Действия</th>
                </tr>
                @if($tests->count())
                    @foreach($tests as $test)
                        <tr>
                            <td>
                                {{$test->tests_id}}
                            </td>
                            <td>
                                {{$test->category_name}}
                            </td>
                            <td>
                                <a href="/simple-test-system-question/{{$test->tests_id}}">{{$test->tests_name}}</a>
                            </td>
                            <td class="td-btn-flex-1">
                                <form action="/simple-test-system-test/{{$test->tests_id}}/edit" method="GET" style="">
                                    <button class="mg-btn-1" type="submit" title="редактировать">
                                        <a href="/simple-test-system-test/{{$test->tests_id}}/edit">
                                            <svg height="22" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true" class="mg-btn-edit"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
                                        </a>
                                    </button>
                                </form>

                                <form action="/simple-test-system-test/{{$test->tests_id}}" class="shorturl-delete-button" method="POST" style="">
                                    @csrf
                                    @method('DELETE')
                                    <button class="mg-btn-1 " type="submit" title="удалить">
                                        <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                @endif
            </table>
        </div>

    </div>

@endsection