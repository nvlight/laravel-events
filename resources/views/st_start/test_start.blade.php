@extends('layouts.test')

@section('content')

    <div class="container">
        <div class="row">

            <div class="col-sm-10 offset-sm-1">

                <h3>Тестирование начато</h3>
                <h4>{{$getNames[0]['category']}} - {{$getNames[0]['test_name']}}. {{$getNames[0]['selection']}}</h4>

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

                //echo \App\Debug::d(request()->all());
                //dump($themesWithChildRandomQsts);
                //echo \App\Debug::d($themesWithChildRandomQsts);
                if (session()->has($started_config_key)){
                    echo \App\Debug::d(session()->get($started_config_key));
                }
                ?>

                <form action="/tests/results" method="POST" class="mb-3 mt-3">
                    @csrf
                    <input type="hidden" name="shedule_id" value="{{$getNames[0]['shedule_id']}}">
                    <input type="hidden" name="category_id" value="{{$getNames[0]['category_id']}}">
                    <input type="hidden" name="test_id" value="{{$getNames[0]['test_id']}}">
                    <input type="hidden" name="selected_qsts_id" value="{{$getNames[0]['selected_qsts_id']}}">

                    <?php $qst_count = 0; ?>
                    @foreach($themesWithChildRandomQsts as $k => $v)
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
                                               value="{{$vvv['id']}}"
                                                >
                                            <label for="id_{{$vvv['number']}}_{{$vvv['id']}}">{{$vvv['description']}}</label>
                                            <br>
                                            @break
                                        @case(2)
                                            <input type="checkbox" name="checkbox_qst_number_{{$vvv['number']}}[]" id="id_{{$vvv['number']}}_{{$vvv['id']}}"
                                               value="{{$vvv['id']}}"
                                                >
                                            <label for="id_{{$vvv['number']}}_{{$vvv['id']}}">{{$vvv['description']}}</label>
                                            <br>
                                            @break
                                    @endswitch
                                @endforeach

                        @endforeach
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
                                url:'/tests/save-result',
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
                    </script>

                    <button type="submit" class="btn btn-primary">End this test!</button>

                </form>

            </div>

        </div>
    </div>

@endsection