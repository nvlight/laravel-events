@extends('layouts.test_geek1')

@section('content')

    <link href="{{ asset('css/geek_test/test_detail/vendor.0d5f9223a1f958d314fb.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/geek_test/test_detail/app.4bc4dbb916729b5c2908.css') }}" rel="stylesheet" media="all">

    <?php
    $diffInSeconds = $timeDiff['diffInSeconds'];
    $miniutes = ($diffInSeconds >= 60) ? intval($diffInSeconds  / 60) : 0;
    $seconds = ($diffInSeconds % 60 !== 0) ? $diffInSeconds % 60 : 0;
    //echo \App\Debug::d($timeDiff);
    //<h4>Длительность теcтирования: {{$miniutes}} минут(а,ы) {{$seconds}} секунд(а,ы) из {{$result['questionsCountAndDurationNumber'][0]['duration']}} минут</h4>
    ?>

    <div class="resulst_block" style="padding: 20px; margin-top: 100px; ">
        <h2 class="h1" >Результаты тестирования</h2>
        <h4 class="h1">Имя банка ТЗ: {{$sessionInner['category']}} - {{$sessionInner['test_name']}} ({{$result['questionsCountAndDurationNumber'][0]['qsts_count']}} вопросов на {{$result['questionsCountAndDurationNumber'][0]['duration']}} минут)</h4>
        <h5 class="h2">Результат: {{$result['balls']}} из {{$result['questionsCountAndDurationNumber'][0]['qsts_count']}}</h5>
        <h4 class="h2">Время: {{$miniutes}} : {{$seconds}} </h4>
        <h5 class="h2">Процентов: <?php echo round( ($result['balls'] / $result['questionsCountAndDurationNumber'][0]['qsts_count']) * 100 , 2); ?>%</h5>
        <div class="" >
            <?php
            //echo \App\Debug::d($result);
            //echo \App\Debug::d($sessionInner)
            ?>

        </div>
        <a href="/tests">На главную!</a>
    </div>

@endsection