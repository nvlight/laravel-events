@extends('layouts.event')

@section('content')

    <?php
    //echo \App\Debug::d($events);
    //echo \App\Debug::d($categories);
    //echo \App\Debug::d($types);
    ?>


    <style>
        .dropdown-menu.show {
            transform: translate3d(0px, 0px, 0px) !important;
        }

        .dropdown-toggle.btn-light + .dropdown-menu{
            margin-top: 40px;
        }
    </style>

    {{-- заглушка для поиска по селекту --}}
{{--    <div class="row">--}}
{{--        <div class="col-md-6">--}}
{{--            <div class="form-group">--}}
{{--                <label for="exampleDropdown">#1 # Dropdown Select with "data-live-search" </label>--}}
{{--                <select data-live-search="true" class="form-control selectpicker">--}}
{{--                    <option>Mango</option>--}}
{{--                    <option>Orange</option>--}}
{{--                    <option>Lychee</option>--}}
{{--                    <option>Pineapple</option>--}}
{{--                    <option>Apple</option>--}}
{{--                    <option>Banana</option>--}}
{{--                    <option>Grapes</option>--}}
{{--                    <option>Water Melon</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row">

        <div class="col-md-6">
            <h3>Создание события</h3>
            <a href="/event">Список событий</a>
            <form action="/event" method="POST">
                @csrf


                {{-- новый селект --}}
                <div class="mb-3">
                    <label for="category_id">Категория</label>
                    <select data-live-search="true" class="form-control selectpicker" name="category_id" id="category_id">
                        <option value="0" selected>Не выбрано</option>
                        @if($categories->count())
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" >{{$category->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="type_id">Тип</label>
                    <select data-live-search="true" class="form-control selectpicker" name="type_id" id="type_id">
                        <option value="0" selected>Не выбрано</option>
                        @if($types->count())
                            @foreach($types as $types)
                                <option value="{{$types->id}}" >{{$types->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>


            {{-- старый селект --}}
{{--                <div class="mb-3">--}}
{{--                    <label for="category_id">Категория</label>--}}
{{--                    <select class="form-control" name="category_id" id="category_id">--}}
{{--                        <option value="0" selected>Не выбрано</option>--}}
{{--                        @if($categories->count())--}}
{{--                            @foreach($categories as $category)--}}
{{--                                <option value="{{$category->id}}" >{{$category->name}}</option>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <div class="mb-3">--}}
{{--                    <label for="type_id">Тип</label>--}}
{{--                    <select class="form-control" name="type_id" id="type_id">--}}
{{--                        <option value="0" selected>Не выбрано</option>--}}
{{--                        @if($types->count())--}}
{{--                            @foreach($types as $types)--}}
{{--                                <option value="{{$types->id}}" >{{$types->name}}</option>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    </select>--}}
{{--                </div>--}}


                <div class="mb-3">
                    <label for="date">Дата</label>
                    <input data-provide="datepicker" class="form-control {{ $errors->has('date') ? 'border-danger' : '' }} mg-date-maxw101" id="date" name="date" placeholder="<?=Date('d.m.Y')?>" value="<?=Date('d.m.Y')?>" >
                </div>

                <div class="mb-3">
                    <label for="amount">Сумма</label>
                    <input class="form-control {{ $errors->has('amount') ? 'border-danger' : '' }}" id="amount" name="amount" placeholder="500" value="{{old('amount')}}" >
                </div>

                <div class="mb-3">
                    <label for="description">Описание</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'border-danger' : '' }}" name="description" id="description" cols="30" rows="10">{{old('description')}}</textarea>
                </div>


                <script>
                    $('#date').datepicker({
                        'format' : 'dd.mm.yyyy',
                        'language' : 'ru',
                        'zIndexOffset' : 1000,
                    });
                    $('#description').summernote({
                        placeholder: 'type description here...',
                        tabsize: 4,
                        height: 110
                    });
                </script>

                @include('errors')

                <div class="mb-3">
                    <button class="btn btn-success">Создать</button>
                </div>

            </form>
        </div>

    </div>

@endsection