@extends('layouts.event')

@section('content')

    <h4><a href="/simple-test-system">Список банка ТЗ</a></h4>

    <h4 class="mb-3">Банк ТЗ - <span class="mg-span-fz11">{{$test_curr->name}} ({{$test_curr->id}}) </span></h4>

    <div class="btn-group mb-3">
        <button class="btn btn-secondary" onclick="openTab('mainAddQuestions')">Вопросы</button>
        <button class="btn btn-secondary" onclick="openTab('mainThemes')">Темы</button>
        <button class="btn btn-secondary" onclick="openTab('mainRasps')">Расписания</button>
    </div>

    <div id="mainAddQuestions" class="w3-container myTab">

        <h3>Работа с темами/вопросами</h3>

        <div class="row">
            <div class="col-sm-6">
                <h5>Добавление темы </h5>

                <form action="/simple-test-system-question-theme/{{$test_curr->id}}" method="POST" id="question_theme" class="mb-3">
                    @csrf

                    <div class="mb-3">
                        <label for="question_theme_add">Название темы</label>
                        <input type="text" name="theme" class="form-control" placeholder="theeeme" id="question_theme_add">
                    </div>

                    <div class="mb-3">
                        <label for="question_theme_parent">Родительская тема</label>
                        <select name="theme_parent" id="question_theme_parent" class="form-control">
                            <option value="0">Не выбрана</option>
                            @if($themes->count())
                                @foreach($themes as $theme)
                                    <option value="{{$theme->id}}">{{$theme->description}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="theme_add_message">
                        @if(session()->has('add_question_theme'))
                            @if(session()->get('add_question_theme')['success'] === 1)
                                <?php $add_question_theme_className = 'text-success'; ?>
                                <h5 class="{{$add_question_theme_className}}">Тема добавлена!</h5>
                            @else
                                <?php $add_question_theme_className = 'text-danger'; ?>
                                <?php //dd(session()->get('add_question_theme')['message']->getMessages()); ?>
                                @foreach(session()->get('add_question_theme')['message']->getMessages() as $key => $value)
                                    <p class="{{$add_question_theme_className}}">
                                        {{$key}} - {{$value[0]}}
                                    </p>
                                @endforeach
                            @endif

                        @endif
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-success">Добавить тему</button>
                    </div>
                </form>

            </div>

            <div class="col-sm-6">
                <h5>Добавление вопроса</h5>

                <div class="mb-3">
                    <label for="question_theme_select">Тема вопроса</label>
                    <select class="form-control" name="parent_id" id="question_theme_select">
                        <option value="0">Тема не выбрана</option>
                        @if($themes->count())
                            @foreach($themes as $theme)
                                <option value="{{$theme->id}}">{{$theme->description}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="qtype_select_id">Тип вопроса</label>
                    <select class="form-control" name="parent_id" id="qtype_select_id">
                        <option value="0">Не выбрано</option>
                        @if($question_types->count())
                            @foreach($question_types as $question_type)
                                <option value="{{$question_type->id}}"><strong>{{$question_type->name}}</strong> - {{$question_type->description}}</option>
                            @endforeach
                        @endif
                    </select>

                </div>

                <h5 class="text-success add_question_success_ajax"><?=session()->get('add_question_success')?></h5>
                <h5 class="text-danger add_question_error_ajax"><?=session()->get('add_question_error')?></h5>

                <div class="mb-3 forms_for_qst_types">
                    <form action="/simple-test-system-question" method="POST" id="question_type_1" class="d-none">
                        @csrf

                        <input type="hidden" name="parent_id" value="{{$test_curr->id}}">
                        <input type="hidden" name="question_type" value="0">
                        <input type="hidden" name="question_theme_id" value="0">

                        <div class="mb-3">
                            <label for="question_type_1_qstnum_1">Описание вопроса</label>
                            <input class="form-control" type="text" name="question_description" id="question_type_1_qstnum_1">
                        </div>

                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Answer</th>
                                <th>controls</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr class="answer_number_1">
                                <td>1</td>
                                <td>
                                    <input class="form-control" type="text" name="answer1">
                                    <input type="hidden" name="hidden_answer_1" value="3">
                                </td>
                                <td>
                                    <span class="badge badge-danger active">False</span>
                                    <span class="badge badge-success add_answer pl-2 pr-2">+</span>
                                    <span class="badge badge-danger del_answer pl-2 pr-2">-</span>
                                </td>
                            </tr>

                            </tbody>

                        </table>

                        @include('errors')

                        <div class="mb-3">
                            <button class="btn btn-success ">Добавить вопрос</button>
                        </div>
                    </form>
                </div>

            </div>

            <?php
            function getTree($array, $level=0, $indent=0){

                //echo \App\Debug::d($array);
                $current = "";
                foreach($array as $k => $v)
                {
                    $url_for_show = "";
                    //echo \App\Debug::d($v); die;
                    if ($v['theme_id'] == $level){
                        $description_type = '';
                        switch ($v['description_type']){
                            case 7:
                                $description_type = 'Тема';
                                $url_for_show = 'sts-theme';
                                //$url_for_edit = 'sts-theme-edit';
                                break;
                            case 1:
                                $description_type = 'Вопрос';
                                $url_for_show = 'sts-question';
                                //$url_for_edit = 'sts-question-edit';
                                break;
                        }

                        $indent_html = str_repeat("&mdash;", $indent);

                        $crsf_field = csrf_field();
                        $method_delete = method_field('DELETE');

                        $cqt = $v['child_question_count'] == 0 ? '' : $v['child_question_count'];
                        $current .= <<<STR
                <tr class="">
                    <td>{$v['id']}</td>
                    <td>{$v['theme_id']}</td>
                    <td>{$description_type}</td>
                    <td>{$indent_html} {$v['description']}</td>
                    <td>{$cqt}</td>
                    <td class="td-btn-flex-1">


                        <a href="/{$url_for_show}/{$v['id']}">
                            <button class="mg-btn-1" type="submit" title="просмотреть">
                                <svg height="25" class="mg-btn-show" viewBox="0 0 12 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M6 5H2V4h4v1zM2 8h7V7H2v1zm0 2h7V9H2v1zm0 2h7v-1H2v1zm10-7.5V14c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1V2c0-.55.45-1 1-1h7.5L12 4.5zM11 5L8 2H1v12h10V5z"></path></svg>
                            </button>
                        </a>

                        <a href="/{$url_for_show}/{$v['id']}/edit">
                            <button class="mg-btn-1" type="submit" title="редактировать">
                                <svg height="22" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true" class="mg-btn-edit"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
                            </button>
                        </a>

                        <form action="/simple-test-system-question/{$v['id']}" class="shorturl-delete-button" method="POST" style="">
                            {$crsf_field}
                            {$method_delete}
                            <button class="mg-btn-1 " type="submit" title="удалить">
                                <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                            </button>
                        </form>
                    </td>

                </tr>
STR;
                        $indent++;
                        if (array_key_exists('child', $v)){
                            //dd($v['child']);
                            $curr_function = __FUNCTION__;
                            $current .= $curr_function($v['child'], $v['id'], $indent);
                        }
                        $indent--;
                    }
                }
                //echo \App\Debug::d($current);
                return $current;
            }

            function getTree2($array, $level=0, $indent=0)
            {
                $current = "";
                foreach($array as $k => $v)
                {
                    if ($v['theme_id'] == $level)
                    {
                        if ($v['description_type'] === 7)
                        {
                            $indent_html = str_repeat("&mdash;", $indent);

                            $cqt = $v['child_question_count'];
                            $current .= <<<STR
                            <tr class="">
                                <td>{$v['id']}</td>
                                <td>{$v['theme_id']}</td>
                                <td>{$indent_html} {$v['description']}</td>
                                <td>{$cqt}</td>
                            </tr>
STR;
                            $indent++;

                            if (array_key_exists('child', $v)){
                                $curr_function = __FUNCTION__;
                                $current .= $curr_function($v['child'], $v['id'], $indent);
                            }
                            $indent--;
                        }
                    }
                }
                return $current;
            }

            //dump($catsThemesWithQuestionChilds);

            $output_array = [];
            // на этот раз будем возращать массив, а потом будем по нему идти
            function getTree3($array, $level=0, $indent=0, &$output_array)
            {
                $current = [];
                foreach($array as $k => $v)
                {
                    if ($v['theme_id'] == $level)
                    {
                        if ($v['description_type'] === 7)
                        {
                            $indent_html = str_repeat("&mdash;", $indent);

                            $cqt = $v['child_question_count'];

                            $tmp = [
                                'id' => $v['id'],
                                'theme_id' => $v['theme_id'],
                                'indent_html' => $indent_html,
                                'description' => $v['description'],
                                'qst_count' => $cqt,
                                'indent' => $indent,
                            ];

                            $output_array[] = $tmp;
                            $indent++;

                            if (array_key_exists('child', $v)){
                                $curr_function = __FUNCTION__;
                                $tmp['child'] = $curr_function($v['child'], $v['id'], $indent, $output_array);
                                if (!count($tmp['child'])){
                                    unset($tmp['child']);
                                }
                            }
                            $indent--;


                            $current[] = $tmp;

                        }
                    }
                }
                return $current;
            }

            ?>

            <script>
                $('#qtype_select_id').on('change', function (e) {
                    let qst_type = $(this).val();
                    qst_type *= 1;
                    //console.log('select changed: id='+ qst_type);
                    //console.log('select switched: '+qst_type);
                    $('.forms_for_qst_types form').addClass('d-none');
                    $("#question_type_1 input[name=question_type]").val(qst_type);
                    $('.add_question_success_ajax').html('');
                    $('.add_question_error_ajax').html('');

                    switch (qst_type) {
                        case 1:
                            $('#question_type_1').removeClass('d-none');
                            break;
                        case 2:
                            $('#question_type_1').removeClass('d-none');
                            break;
                        case 3:
                            break;
                        case 4:
                            break;
                        case 5:
                            break;
                        default:
                    }
                });

                $('#question_theme_select').on('change', function (e) {
                    let theme_id = $(this).val();
                    theme_id *= 1;
                    console.log('theme_id: '+theme_id);
                    $('#question_type_1 input[name=question_theme_id]').val(theme_id);
                });

                //
                function append_tr_to_table(e){
                    // получения номера последней tr
                    let trs = $('#question_type_1 [class^=answer_number_]:last-child').attr('class');
                    trs = trs.replace('answer_number_','');
                    //console.log(trs);
                    trs *= 1; trs += 1;

                    $('#question_type_1 tbody').append(
                        '<tr class="answer_number_' + trs + '">'+
                        '<td>' + trs +'</td>'+
                        '<td>'+
                        '    <input class="form-control" type="text" name="answer' + trs + '">'+
                        '    <input type="hidden" name="hidden_answer_' + trs + '" value="3">' +
                        '</td>'+
                        '<td>'+
                        '    <span class="badge badge-danger active">False</span>'+
                        '    <span class="badge badge-success add_answer pl-2 pr-2">+</span>'+
                        '    <span class="badge badge-danger del_answer pl-2 pr-2">-</span>'+
                        '</td>'+
                        '</tr>'
                    );
                }
                //
                $('#question_type_1 .add_answer').on('click', function (e) {
                    //append_tr_to_table(e);
                    //return false;
                });
                $('#question_type_1').on('click', '.add_answer', function (e) {
                    append_tr_to_table(e);
                    return false;
                });

                //
                function del_tr_from_table(e,th){
                    let trs = $('#question_type_1 [class^=answer_number_]');
                    //console.log(trs.length);
                    if (trs.length > 1){
                        let curr_tr = $(th).parent().parent();
                        curr_tr.remove();
                    }
                }
                //
                $('#question_type_1 .del_answer').on('click', function (e) {
                    //del_tr_from_table(e,this);
                });
                $('#question_type_1').on('click', '.del_answer', function (e) {
                    del_tr_from_table(e,this);
                });

                //
                function add_badge_success(e,th){
                    //console.log('add_badge_success');
                    $(th).removeClass('badge-danger').addClass('badge-success','active').html('True');
                }
                function add_badge_danger(e,th){
                    //console.log('add_badge_delete');
                    $(th).removeClass('badge-success').addClass( 'badge-danger').html('False');
                }
                // $('tr[class^=answer_number_] .badge-danger.active').on('click', function (e) {
                //     add_badge_success(e,this)
                // });
                // $('tr[class^=answer_number_] .success.active').on('click', function (e) {
                //     add_badge_danger(e,this);
                // });
                $('#question_type_1').on('click', '.badge-danger.active', function (e) {
                    add_badge_success(e,this);

                    let tr_id = $(this).parent().parent().attr('class');
                    tr_id = tr_id.replace('answer_number_','');
                    console.log(tr_id);
                    $('input[name=hidden_answer_'+tr_id+']').val('2');
                });
                $('#question_type_1').on('click', '.badge-success.active', function (e) {
                    add_badge_danger(e,this);

                    let tr_id = $(this).parent().parent().attr('class');
                    tr_id = tr_id.replace('answer_number_','');
                    console.log(tr_id);
                    $('input[name=hidden_answer_'+tr_id+']').val('3');
                });

                $('#question_type_1').submit(function (e) {

                    e.preventDefault();

                    $.ajax({
                        type:'POST',
                        url:'/sts-add-question',
                        data: $(this).serialize(),
                        success:function(data){
                            //console.log(data.message);
                            if (data.success === 1){
                                //$(this).submit();
                                location.reload(true);
                            } else {
                                $('.add_question_error_ajax').html(data.errors);
                                return false;
                            }
                        }
                    });

                });

            </script>

        </div>

        <div class="row">
            <div class="col-md-12">

                <h5>Список вопросов</h5>

                <h5 class="text-danger">{{session()->get('del_question')}}</h5>
                <table class="table table-bordered table-striped mb-3">
                    <tr>
                        <th>id</th>
                        <th>theme_id</th>
                        <th>Тип</th>
                        <th>description</th>
                        <th>qcount</th>
                        <th>controls</th>
                    </tr>
                    @if(count($catsThemesWithQuestionChilds))
                        <?= getTree($catsThemesWithQuestionChilds)?>
                    @endif
                </table>

                <?php $anather_selections_show = false; ?>
                @if($anather_selections_show)
                    <h5>Список вопросов - простой</h5>
                    <table class="table table-bordered table-striped mb-3">
                        <tr>
                            <th>id</th>
                            <th>nm</th>
                            <th>thm</th>
                            <th>qt</th>
                            <th>description</th>
                            <th>dt</th>
                        </tr>
                        @if($questions->count())
                            @foreach($questions as $question)
                                <tr>
                                    <td>{{$question->id}}</td>
                                    <td>{{$question->number}}</td>
                                    <td>{{$question->theme_id}}</td>
                                    <td>{{$question->type}}</td>
                                    @if($question->description_type == 1)
                                        <td><strong>{{$question->description}}</strong></td>
                                    @else
                                        <td>{{$question->description}}</td>
                                    @endif

                                    <td>{{$question->description_type}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>Список вопросов пуст</td>
                            </tr>
                        @endif
                    </table>
                @endif

            </div>
        </div>

    </div>

    <div id="mainThemes" class="w3-container myTab" style="display:none">
        <h3>Просмотр тем с количеством дочерних вопросов</h3>

        <div class="row">
            <div class="col-md-12">

                <h5>Список вопросов</h5>

                <?php //echo \App\Debug::d(getTree2($catsThemesWithQuestionChilds)); ?>

                <h5 class="text-danger">{{session()->get('del_question')}}</h5>
                <table class="table table-bordered table-striped mb-3">
                    <tr>
                        <th>id</th>
                        <th>theme_id</th>
                        <th>description</th>
                        <th>qcount</th>
                    </tr>
                    @if(count($catsThemesWithQuestionChilds))
                        <?= getTree2($catsThemesWithQuestionChilds) ?>
                    @endif
                </table>

            </div>
        </div>

    </div>

    <div id="mainRasps" class="w3-container myTab" style="display:none">
        <h3>Выборка тем с вопросами, даты, длительности тестирования и его сохранение</h3>
        <h5>Список расписаний</h5>
        <table class="table table-striped table-bordered table-responsive">
            <tr>
                <th>#</th>
                <th>Test_id</th>
                <th>Имя выборки</th>
                <th>Вопросов/минут</th>
                <th>Дата тестирования</th>
                <th>действия</th>
            </tr>
            <?php
            //dump($shedules->toArray());
            ?>
            @if($shedules->count())
                @foreach($shedules as $shedule)
                    <tr>
                        <td>{{$shedule->id}}</td>
                        <td>{{$shedule->test_cat_name}} / {{$shedule->test_name}}</td>
                        <td>{{$shedule->name}}</td>
                        <td>{{$shedule->qsts_count}}/{{$shedule->duration}}</td>
                        <td>{{$shedule->test_started_at}}</td>
                        <td>
                            <form action="/sts-shedule/{{$shedule->id}}" class="shorturl-delete-button" method="POST" style="">
                                @csrf
                                @method('DELETE')
                                <button class="mg-btn-1 " type="submit" title="удалить">
                                    <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>Нет записей</td>
                </tr>
            @endif
        </table>
        @if(session()->has('deleteElementFromShedulesWithSelectedQstsChilds'))
            <?php //dump(session()->get('deleteElementFromShedulesWithSelectedQstsChilds')); ?>
            @if(session()->get('deleteElementFromShedulesWithSelectedQstsChilds')['success'] === 1)
                <h5 class="text-success">{{session()->get('deleteElementFromShedulesWithSelectedQstsChilds')['message']}}</h5>
            @else
                <p class="text-danger">{{session()->get('deleteElementFromShedulesWithSelectedQstsChilds')['message']}}</p>
            @endif
        @endif

        @if(session()->has('addNewSelectedQsts'))
            <?php //dump(session()->get('addNewSelectedQsts')); ?>
            @if(session()->get('addNewSelectedQsts')['success'] === 1)
                <h5 class="text-success">{{session()->get('addNewSelectedQsts')['message']}}</h5>
            @else
                <p class="text-danger">Ошибки: </p>
                @foreach(session()->get('addNewSelectedQsts')['message'] as $k => $v)
                    <p>{{$k}} - {{$v[0]}}</p>
                @endforeach
            @endif
        @endif
        <h5>Добавление расписания</h5>
        <?php
        $output_array = [];
        //dump($catsThemesWithQuestionChilds);
        getTree3($catsThemesWithQuestionChilds,0,0,$output_array)
        //dump(getTree3($catsThemesWithQuestionChilds,0,0,$output_array));
        //dump($output_array);
        ?>

        <div class="row ml-0 mr-0">
            <div class="md-6">

                <form action="/sts-shedule" method="POST">
                    @csrf

                    <input type="hidden" name="test_id" value="{{$test_curr->id}}">

                    <div class="input-group mb-3 ">
                        <div class="mr-3">
                            <label for="selected_qst_name">Выборка</label>
                            <input class="form-control" type="text" name="selected_qst_name" id="selected_qst_name" placeholder="Введите имя выборки" >
                        </div>
                        <div class="mr-3">
                            <label for="selected_qst_duration">Длительность</label>
                            <input class="form-control mg-duration-maxw101" type="text" name="selected_qst_duration" id="selected_qst_duration" placeholder="Минут" >
                        </div>

                        <div class="mr-3">
                            <label for="selected_qst_test_started_at">Дата тестирования</label>
                            <input data-provide="datepicker" class="form-control mg-date-maxw101" id="selected_qst_test_started_at" name="selected_qst_test_started_at" placeholder="<?=Date('d.m.Y')?>" value="<?=Date('d.m.Y')?>" >
                        </div>
                    </div>


                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Theme_ID</th>
                            <th>Описание</th>
                            <th>Всего вопросов в теме</th>
                            <th>Выбрано вопросов</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($output_array as $k => $v)
                            <tr>
                                <td>{{$v['id']}}</td>
                                <td>{{$v['theme_id']}}</td>
                                <td><?=$v['indent_html']?> {{$v['description']}}</td>
                                <td>{{$v['qst_count']}}</td>
                                <td><input type="text" class="form-control" name="qst_theme_id_{{$v['id']}}" placeholder="0" value="0"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary">Создать выборку</button>
                </form>

            </div>
        </div>

    </div>

    <script>
        function openTab(tabName) {
            var i;
            var x = document.getElementsByClassName("myTab");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";
        }
        openTab('mainRasps');

        $('#selected_qst_test_started_at').datepicker({
            'format' : 'dd.mm.yyyy',
            'language' : 'ru',
            'zIndexOffset' : 1000,
        });

    </script>


@endsection