@extends('layouts.test')

@section('content')
    <div id="mg_content">
        <div class="container">
            <div class="row">

                <div class="col-sm-6">

                    <?php
                    //dump($theme_ids);
                    //dump($shedule_id->toArray());

                    ?>
                    <div class="test_themes mt-3">
                        <form action="/tests/start" method="POST">
                            @csrf
                            <input type="hidden" name="shedules_id" value="{{$shedule_id->id}}">
                            <p class="mg_tests_title">Тестирование по: {{$testBreadCrumbs->first()->category}} - {{$testBreadCrumbs->first()->test_name}}</p>

                            <h5>Имя выборки: {{$shedule_id->name}}</h5>
                            <h5>Темы</h5>
                            @if(count($theme_ids))
                                <ul>
                                    @foreach($theme_ids as $theme)
                                        <li>{{$theme['description']}}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <h5>Время: {{$shedule_id->duration}} минут</h5>
                            <h5>Вопросов: {{$shedule_id->qsts_count}}</h5>
                            <h5>Интервал попыток: 1 день</h5>
                            <div class="mg_start_test_button">
                                <button class="btn btn-primary">Начать тестирование!</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

