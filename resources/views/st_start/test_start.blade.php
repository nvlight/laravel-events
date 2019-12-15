@extends('layouts.test_geek1')

@section('content')

    <link href="{{ asset('css/geek_test/test_detail/vendor.0d5f9223a1f958d314fb.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/geek_test/test_detail/app.4bc4dbb916729b5c2908.css') }}" rel="stylesheet" media="all">

    <div id="mg_content">

        <div class="container">
            <div class="row">

             <div class="col-sm-10 offset-sm-1">

                 <div class="mg_test__header__caption">
                     <h3 class="h1">Тестирование начато</h3>
                     <h4 class="h2">{{$getNames[0]['category']}} - {{$getNames[0]['test_name']}} ({{$getNames[0]['selection']}})</h4>
                     <h5 class="h2">Вопросов всего: {{$getNames[0]['qsts_count']}}</h5>
                     <h5 class="h2">Времени всего: {{$getNames[0]['duration']}} минут</h5>
                 </div>

                 <div id="mg_test__header__wrapper">

                     <div id="mg_test__header">
                         <svg height="32" class="octicon octicon-watch countdown_clock_svg" viewBox="0 0 12 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M6 8h2v1H5V5h1v3zm6 0c0 2.22-1.2 4.16-3 5.19V15c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1v-1.81C1.2 12.16 0 10.22 0 8s1.2-4.16 3-5.19V1c0-.55.45-1 1-1h4c.55 0 1 .45 1 1v1.81c1.8 1.03 3 2.97 3 5.19zm-1 0c0-2.77-2.23-5-5-5S1 5.23 1 8s2.23 5 5 5 5-2.23 5-5z"></path></svg>
                         <div class="mg_test__header__countdown_timer">
                            <div class="mg_countdown_wrapper">
                                <div id="mg_countdown">
                            <span>
                                <span class="mg_countdown days">Days</span>:
                            </span>
                            <span>
                                <span class="mg_countdown hours">Hours</span>:
                            </span>
                            <span>
                                <span class="mg_countdown minutes">Minutes</span>:
                            </span>
                            <span>
                                <span class="mg_countdown seconds">Seconds</span>
                            </span>
                                </div>
                            </div>
                         </div>
                      </div>

                 </div>

                <style>
                    .mg_countdown_wrapper{
                        display: flex;
                        justify-content: flex-end;
                    }
                    #mg_countdown{
                        display: flex;
                        font-size: 25px;
                    }
                </style>
                <script>
                    function getTimeRemaining(endtime) {
                        var t = Date.parse(endtime) - Date.parse(new Date());
                        var seconds = Math.floor((t / 1000) % 60);
                        var minutes = Math.floor((t / 1000 / 60) % 60);
                        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
                        var days = Math.floor(t / (1000 * 60 * 60 * 24));
                        return {
                            'total': t,
                            'days': days,
                            'hours': hours,
                            'minutes': minutes,
                            'seconds': seconds
                        };
                    }

                    function initializeClock(id, endtime) {
                        var clock = document.getElementById(id);
                        var daysSpan = clock.querySelector('.days');
                        var hoursSpan = clock.querySelector('.hours');
                        var minutesSpan = clock.querySelector('.minutes');
                        var secondsSpan = clock.querySelector('.seconds');

                        function updateClock() {
                            var t = getTimeRemaining(endtime);

                            daysSpan.innerHTML = t.days;
                            hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
                            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                            var toHide = [[t.days, daysSpan], [t.hours, hoursSpan]];
                            //var toHide = [];
                            for(let i=0; i<toHide.length; i++){
                                if (toHide[i][0] === 0){
                                    //console.warn(toHide[i][1]);
                                    toHide[i][1].parentElement.style.display = 'none';
                                }
                            }

                            if (t.total <= 0) {
                                $('#form_testSystemMain').submit();
                                clearInterval(timeinterval);
                            }
                        }

                        updateClock();
                        var timeinterval = setInterval(updateClock, 1000);
                    }

                    var deadline="December 01 2018 00:00:00 GMT+0300"; //for Ukraine
                    <?php
                        //$deadOffset = 500;
                        if (session()->has($started_config_key)){
                            $arrSession = session()->get($started_config_key);
                            $deadOffset = $arrSession['duration'];
                        }
                        // $timeDiff['etalonDiffInSeconds']
                    ?>
                    var deadOffset = <?=($timeDiff['etalonDiffInSeconds'] - $timeDiff['diffInSeconds'])?>;
                    var deadline = new Date(Date.parse(new Date()) + deadOffset * 1000); // for endless timer
                    initializeClock('mg_countdown', deadline);

                    // надо сделать так, чтобы при истечении всего времени отправить форму!
                    function stopTestCountdown(id, endtime) {
                        var clock = document.getElementById(id);
                        var daysSpan = clock.querySelector('.days');
                        var hoursSpan = clock.querySelector('.hours');
                        var minutesSpan = clock.querySelector('.minutes');
                        var secondsSpan = clock.querySelector('.seconds');

                        function updateClock() {
                            var t = getTimeRemaining(endtime);

                            daysSpan.innerHTML = t.days;
                            hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
                            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                            var toHide = [[t.days, daysSpan], [t.hours, hoursSpan]];
                            //var toHide = [];
                            for(let i=0; i<toHide.length; i++){
                                if (toHide[i][0] === 0){
                                    //console.warn(toHide[i][1]);
                                    toHide[i][1].parentElement.style.display = 'none';
                                }
                            }

                            if (t.total <= 0) {
                                clearInterval(timeinterval);
                                console.warn('Шах, следующим ходом мат - ты проиграл!');
                                $('#form_testSystemMain').submit();
                            }
                        }

                        updateClock();
                        var timeinterval = setInterval(updateClock, 1000);
                    }
                    //stopTestCountdown('mg_countdown', new Date(Date.parse(new Date()) + 5 * 1000));

                </script>

                <?php

                /**
                 * @param array $qst
                 * @return string
                 */
                function getQuestionDescription(array $qst):string{
                    $description = "";
                    foreach($qst as $item)
                        if ($item['description_type'] === 1){
                            $description = $item['description'];
                            break;
                        }
                    return $description;
                }

                /**
                 * @param array $qst
                 * @return array
                 */
                function getQuestionAnswers(array $qst):array{
                    $a = [];
                    foreach($qst as $item)
                        if (filter_var($item['description_type'], FILTER_VALIDATE_INT,
                            [ 'options' => ['min_range' => 2, 'max_range' => 3] ]) ){
                            $a[] = $item;
                        }
                    return $a;
                }

                /**
                 * @param int $questionId
                 * @param int $questionNumber
                 * @param array $savedSearchArray
                 * @return bool
                 */
                function isSavedAnswerTrueForQuestion(int $questionId, int $questionNumber, array $savedSearchArray):bool{

                    $weFind = false;

                    foreach($savedSearchArray as $k => $v){

                        if ($questionNumber === $v['qsts_number']){
                            $answeredIds = explode(';',$v['qsts_answer']);
                            if (in_array($questionId, $answeredIds)){
                                return true;
                            }
                        }

                    }

                    return $weFind;
                }

                //echo \App\Debug::d(request()->all());
                //dump($themesWithChildRandomQsts);
                //echo \App\Debug::d($themesWithChildRandomQsts);
                //echo \App\Debug::d(session()->all());
                $started_config_key = config('services.sts.test_start_session_key');
                if (session()->has($started_config_key)){
                    //echo \App\Debug::d(session()->get($started_config_key));
                }
//                echo \Carbon\Carbon::now();echo "<br>";
//                echo \Carbon\Carbon::now('America/Vancouver');echo "<br>";
//                echo \Carbon\Carbon::now('Europe/Moscow');echo "<br>";
                ?>

{{--                 <button class="btn btn-primary" id="btn_getTimeDiff">btn_getTimeDiff</button>--}}

                <form action="/tests/results" method="POST" class="mb-3 mt-3" id="form_testSystemMain">
                    @csrf
                    <input type="hidden" name="shedule_id" value="{{$getNames[0]['shedule_id']}}">
                    <input type="hidden" name="category_id" value="{{$getNames[0]['category_id']}}">
                    <input type="hidden" name="test_id" value="{{$getNames[0]['test_id']}}">
                    <input type="hidden" name="selected_qsts_id" value="{{$getNames[0]['selected_qsts_id']}}">

                    <?php $qst_count = 0; ?>
                    @foreach($themesWithChildRandomQsts as $k => $v)
                        <div class="questionInner" data-qrndm="<?=str_repeat(strval(rand(1,9999)),3)?>">
                            <h5>Тема: {{$v['description']}}</h5>
                            @foreach($v['child'] as $kk => $vv)
                                <p>
                                    <?php $qst_count++; ?>
                                    <strong>Вопрос {{$qst_count}}. </strong>
                                    {{getQuestionDescription($vv)}}
                                </p>
                                    @foreach(getQuestionAnswers($vv) as $kkk => $vvv)
                                        @switch($vvv['type'])
                                            @case(1)
                                                <input type="radio" name="radio_qst_number_{{$vvv['number']}}[]" id="id_{{$vvv['number']}}_{{$vvv['id']}}"
                                                   value="{{$vvv['id']}}" <?php if(isSavedAnswerTrueForQuestion($vvv['id'],$vvv['number'], $savedQuestionsQnswersByTestNumber['data'])) echo 'checked'; ?>
                                                    data-random="{{$vvv['type']}}<?=rand(1,9999)?>" >
                                                <label for="id_{{$vvv['number']}}_{{$vvv['id']}}">{{$vvv['description']}}</label>
                                                <br>
                                                @break
                                            @case(2)
                                                <input type="checkbox" name="checkbox_qst_number_{{$vvv['number']}}[]" id="id_{{$vvv['number']}}_{{$vvv['id']}}"
                                                   value="{{$vvv['id']}}" <?php if(isSavedAnswerTrueForQuestion($vvv['id'],$vvv['number'], $savedQuestionsQnswersByTestNumber['data'])) echo 'checked'; ?>
                                                    data-random="{{$vvv['type']}}<?=rand(1,9999)?>" >
                                                <label for="id_{{$vvv['number']}}_{{$vvv['id']}}">{{$vvv['description']}}</label>
                                                <br>
                                                @break
                                        @endswitch
                                    @endforeach
                            @endforeach
                        </div>
                    @endforeach

                    <script>
                        $('input[name^=radio_qst_number_], input[name^=checkbox_qst_number_]').on('click', function () {
                            //console.log('ok!');
                            let mid = $(this).attr('id');
                            //console.log(mid);
                            //console.log(mid + ' - ' + $(this).prop('checked'));
                            let qst_type = 0;
                            //console.log(document.getElementById(mid).type);
                            switch (document.getElementById(mid).type) {
                                case "radio": qst_type = 1; break;
                                case "checkbox": qst_type = 2; break;
                            }

                            $.ajax({
                                type:'POST',
                                url:'/tests/save-single-result',
                                data:
                                    '_token='+"<?=csrf_token()?>"+
                                    '&_method=patch'+
                                    '&qst_type='+qst_type+
                                    '&test_number='+"<?=session()->get($started_config_key)['test_number']?>"+
                                    '&params='+mid+'&checked='+$(this).prop('checked'),
                                success:function(data){
                                    if (data.success === 1){
                                    }
                                }
                            });

                        });

                        $('#btn_getTimeDiff_222').on('click', function () {
                            $.ajax({
                                type:'GET',
                                url:'/tests/get-time-diff',
                                data: {},
                                success:function(data){
                                    if (data.success === 1){
                                    }
                                }
                            });
                        });

                        $('#btn_getTimeDiff').on('click', function () {
                            $.ajax({
                                type:'GET',
                                url:'/tests/isTetsTimeElapsed',
                                data: {},
                                success:function(data){
                                    if (data.success === 1){
                                    }
                                }
                            });
                        });


                    </script>

                    <button id="testForceEnd" type="submit" class="btn btn-primary">Завершить тестирование!</button>

                    <script>
                        $('#testForceEnd').on('click',function (e) {

                            e.preventDefault();

                            let forceEnd = confirm('Вы действительно хотите завершить тестирование досрочно?');
                            if (!forceEnd){
                                //console.error('its bad!');
                                return false;
                            }

                            $('#form_testSystemMain').submit();
                        });
                    </script>


                </form>

            </div>

            </div>
        </div>

    </div>

@endsection