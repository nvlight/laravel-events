@extends('layouts.test')

@section('content')

    <?php
    $diffInSeconds = $timeDiff['diffInSeconds'];
    $miniutes = ($diffInSeconds >= 60) ? intval($diffInSeconds  / 60) : 0;
    $seconds = ($diffInSeconds % 60 !== 0) ? $diffInSeconds % 60 : 0;
    //echo \App\Debug::d($timeDiff);
    //<h4>Длительность теcтирования: {{$miniutes}} минут(а,ы) {{$seconds}} секунд(а,ы) из {{$result['questionsCountAndDurationNumber'][0]['duration']}} минут</h4>
    ?>

    <div class="resulst_block" style="padding: 20px; margin-top: 100px; ">
        <h2 class="" >Результаты тестирования</h2>
        <h4>Имя банка ТЗ: {{$sessionInner['category']}} - {{$sessionInner['test_name']}} ({{$result['questionsCountAndDurationNumber'][0]['qsts_count']}} вопросов на {{$result['questionsCountAndDurationNumber'][0]['duration']}} минут)</h4>
        <h4>Длительность теcтирования: {{$miniutes}} минут {{$seconds}} секунд</h4>
        <h5>Правильных ответов: {{$result['balls']}}</h5>
        <h5>Баллов: <?php echo round( ($result['balls'] / $result['questionsCountAndDurationNumber'][0]['qsts_count']) * 100 , 2); ?>%</h5>
        <div class="" >
            <?php
            //echo \App\Debug::d($result);
            //echo \App\Debug::d($sessionInner)
            ?>

        </div>
    </div>

@endsection