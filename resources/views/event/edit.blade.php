@extends('layouts.event')

@section('content')

    <?php
    //echo \App\Debug::d($events);
    //echo \App\Debug::d($categories);
    //echo \App\Debug::d($types);
    ?>

    <div class="row">
        <div class="col-md-6">
            <h3>Редактирование события</h3>
            <a href="/event">Список событий</a>
            <form action="/event/{{$event->id}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="category_id">Категория</label>
                    <select class="form-control" name="category_id" id="category_id">
                        @if($categories->count())
                            @foreach($categories as $category)
                                @if($event->category_id === $category->id)
                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                @else
                                    <option value="{{$category->id}}" >{{$category->name}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="type_id">Тип</label>
                    <select class="form-control" name="type_id" id="type_id">
                        @if($types->count())
                            @foreach($types as $type)
                                @if($event->type_id === $type->id)
                                    <option value="{{$type->id}}" selected>{{$type->name}}</option>
                                @else
                                    <option value="{{$type->id}}" >{{$type->name}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="date">Дата</label>
                    <input data-provide="datepicker" class="form-control {{ $errors->has('date') ? 'border-danger' : '' }} mg-date-maxw101" id="date" name="date" placeholder="<?=Date('d.m.Y')?>" value="{{$event->date}}" >
                </div>

                <div class="mb-3">
                    <label for="amount">Сумма</label>
                    <input class="form-control {{ $errors->has('amount') ? 'border-danger' : '' }}" id="amount" name="amount" placeholder="500" value="{{$event->amount}}" >
                </div>

                <div class="mb-3">
                    <label for="description">Описание</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'border-danger' : '' }}" name="description" id="description" cols="30" rows="10">{{$event->description}}</textarea>
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
                    <button class="btn btn-success">Сохранить</button>
                </div>

            </form>
        </div>

    </div>

@endsection