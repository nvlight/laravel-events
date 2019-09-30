@extends('layouts.event')

@section('content')

    <?php
    //echo \App\Debug::d($events);
    //echo \App\Debug::d($categories->toArray());
    //echo \App\Debug::d($category_id);
    //echo \App\Debug::d($types);
    //echo \App\Debug::d($_GET);
    //echo \App\Debug::d($events->count(),'$events->count()');
    //echo \App\Debug::d($vld->fails(),'fails',2);
    //echo \App\Debug::d($events);
    //dd($events);
    ?>

    <a href="/event">Список событий</a>

    <div class="row">

        <div class="col-md-9">
            <h3>Результаты поиска</h3>
            <table class="table table-bordered table-striped table-cover">
                <tr>
                    <th>№</th>
                    <th>Категория</th>
                    <th>Описание</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Действия</th>
                </tr>

                @if(!is_null($events) && $events->count())
                    @foreach($events as $event_key => $event)
                        <tr>
                            <td>{{$event->id}}</td>
                            <td>{{$event->category_name}}</td>
                            <td><?php echo strip_tags($event->description); ?></td>
                            <td>{{$event->amount}}</td>
                            <td>{{$event->date}}</td>
                            <td>
                                <button class="btn" style="background-color: #{{$event->color}}; color: #ffffff;">
                                    {{$event->type_name}}
                                </button>
                            </td>
                            <td class="td-btn-flex-1">

                                <form action="/event/{{$event->id}}" method="GET" style="">
                                    <button class="mg-btn-1" type="submit" title="просмотреть">
                                        <svg height="25" class="mg-btn-show" viewBox="0 0 12 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M6 5H2V4h4v1zM2 8h7V7H2v1zm0 2h7V9H2v1zm0 2h7v-1H2v1zm10-7.5V14c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1V2c0-.55.45-1 1-1h7.5L12 4.5zM11 5L8 2H1v12h10V5z"></path></svg>
                                    </button>
                                </form>

                                <form action="/event/{{$event->id}}/edit" method="GET" style="">
                                    <button class="mg-btn-1" type="submit" title="редактировать">
                                        <svg height="22" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true" class="mg-btn-edit"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
                                    </button>
                                </form>

                                <form action="/event/{{$event->id}}" method="POST" style="">
                                    @csrf
                                    @method('DELETE')
                                    <button class="mg-btn-1" type="submit" title="удалить">
                                        <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" width="28" class="mg-btn-delete"  height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
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

{{--            {{$events->links()}}--}}
        </div>

        <div class="col-md-3">
            <h3>Фильтр событий</h3>

            <form action="" method="GET">
                <div class="mb-3 ">

                    <div>
                        <label for="category_id">Категория</label>
                        <select class="form-control" name="category_id[]" id="category_id" multiple="multiple">
                            <option value="0" >Не выбрано</option>
                            @if($categories->count())

                                @if(!$vld->fails())
                                    @foreach($categories as $category)

                                        <?php $f = false; ?>
                                        @foreach($category_id as $ctg)
                                            @if( $category->id == $ctg )
                                                <?php $f = true; ?>
                                            @endif
                                        @endforeach

                                        @if( $f == true )
                                            <option selected value="{{$category->id}}" >
                                                <span>
                                                    <svg height="32" class="octicon octicon-check" viewBox="0 0 12 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5L12 5z"></path></svg>
                                                </span>
                                                {{$category->name}}
                                            </option>
                                        @else
                                            <option value="{{$category->id}}" >{{$category->name}}</option>
                                        @endif

                                    @endforeach
                                @else
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" >{{$category->name}}</option>
                                    @endforeach
                                @endif

                            @endif
                        </select>
                    </div>


                </div>

                <div class="mb-3">
                    <label for="type_id">Тип</label>
                    <select class="form-control" name="type_id[]" id="type_id" multiple>
                        <option value="0" >Не выбрано</option>
                        @if($types->count())

                            @if(!$vld->fails())
                                @foreach($types as $type)


                                    <?php $f = false; ?>
                                    @foreach($type_id as $tp)
                                        @if( $type->id == $tp )
                                            <?php $f = true; ?>
                                        @endif
                                    @endforeach

                                    @if( $f == true )
                                        <option selected value="{{$type->id}}" >
                                                <span>
                                                    <svg height="32" class="octicon octicon-check" viewBox="0 0 12 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5L12 5z"></path></svg>
                                                </span>
                                            {{$type->name}}
                                        </option>
                                    @else
                                        <option value="{{$type->id}}" >{{$type->name}}</option>
                                    @endif

                                @endforeach
                            @else
                                @foreach($types as $type)
                                    <option value="{{$type->id}}" >{{$type->name}}</option>
                                @endforeach
                            @endif

                        @endif
                    </select>
                </div>


                <div class="mb-3 dts-start-end">

                    <div>
                        <label for="date">Начало периода</label>
                        <input data-provide="datepicker" class="form-control {{ $errors->has('date') ? 'border-danger' : '' }} mg-date-maxw101" id="date1" name="date1" placeholder="<?=Date('d.m.Y')?>" value="<?php !$vld->fails() ? $out = $date_etalon1 : $out = Date('d.m.Y'); echo $out; ?>" >
                    </div>

                    <div>
                        <label for="date">Конец периода</label>
                        <input data-provide="datepicker" class="form-control {{ $errors->has('date') ? 'border-danger' : '' }} mg-date-maxw101" id="date2" name="date2" placeholder="<?=Date('d.m.Y')?>" value="<?php !$vld->fails() ? $out = $date_etalon2 : $out = Date('d.m.Y'); echo $out; ?>" >
                    </div>

                </div>

                <div class="mb-3">

                </div>

                <div class="mb-3 amounts-start-end">
                    <div>
                        <label for="amount">Сумма начальная</label>
                        <input class="form-control {{ $errors->has('amount') ? 'border-danger' : '' }}" id="amount1" name="amount1" placeholder="0"   value="<?php !$vld->fails() ? $out = $amount1 : $out = 0;    echo $out; ?>" >
                    </div>
                    <div>
                        <label for="amount">Сумма конечная</label>
                        <input class="form-control {{ $errors->has('amount') ? 'border-danger' : '' }}" id="amount2" name="amount2" placeholder="500" value="<?php !$vld->fails() ? $out = $amount2 : $out = 5000; echo $out; ?>" >
                    </div>
                </div>

                <script>
                    $('#date1').datepicker({
                        'format' : 'dd.mm.yyyy',
                        'language' : 'ru',
                        'zIndexOffset' : 1000,
                    });
                    $('#date2').datepicker({
                        'format' : 'dd.mm.yyyy',
                        'language' : 'ru',
                        'zIndexOffset' : 1000,
                    });

                </script>

                @include('errors')

                <div class="filter-controls-do-flex">
                    <div class="mb-3">
                        <button class="btn btn-success">Искать</button>
                    </div>

                    <div class="mb-3">
                        <a href="/events-filter" class="btn btn-primary">Сбросить</a>
                    </div>
                </div>

            </form>
        </div>

    </div>

@endsection