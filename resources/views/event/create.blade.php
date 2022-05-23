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
                        @if( !old('category_id'))
                            <option value="" selected>Не выбрано</option>
                        @endif
                        @if($categories->count())
                            @foreach($categories as $category)
                                @if($category->id == old('category_id'))
                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                @else
                                    <option value="{{$category->id}}" >{{$category->name}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @include('errors_show_single', ['column' => 'category_id'])
                </div>

                <div class="mb-3">
                    <label for="type_id">Тип</label>
                    <select data-live-search="true" class="form-control selectpicker" name="type_id" id="type_id">
                        @if( !old('type_id'))
                            <option value="" selected>Не выбрано</option>
                        @endif
                        @if($types->count())
                            @foreach($types as $type)
                                @if($type->id == old('type_id'))
                                    <option value="{{$type->id}}" selected>{{$type->name}}</option>
                                @else
                                    <option value="{{$type->id}}" >{{$type->name}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @include('errors_show_single', ['column' => 'type_id'])
                </div>

                <div class="mb-3">
                    <label for="date">Дата</label>
                    <input data-provide="datepicker" class="form-control {{ $errors->has('date') ? 'border-danger' : '' }} mg-date-maxw101" id="date" name="date" placeholder="<?=Date('d.m.Y')?>" value="<?=Date('d.m.Y')?>" >
                    @include('errors_show_single', ['column' => 'date'])
                </div>

                <div class="mb-3">
                    <label for="description">Описание</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'border-danger' : '' }}" name="description" id="description" cols="30" rows="10">{{old('description')}}</textarea>
                    @include('errors_show_single', ['column' => 'description'])
                </div>

                <div class="mb-3">
                    <label for="amount">Сумма</label>
                    <input class="form-control {{ $errors->has('amount') ? 'border-danger' : '' }}" id="amount" name="amount" placeholder="500" value="{{old('amount')}}" >
                    @include('errors_show_single', ['column' => 'amount'])
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

                <div class="mb-3">
                    <button class="btn btn-success">Создать</button>
                </div>

            </form>
        </div>

    </div>

@endsection
