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

                @include('events-table-data')

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
                        <input class="form-control {{ $errors->has('amount') ? 'border-danger' : '' }}" id="amount2" name="amount2" placeholder="500" value="<?php !$vld->fails() ? $out = $amount2 : $out = 57000; echo $out; ?>" >
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