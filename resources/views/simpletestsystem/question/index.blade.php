@extends('layouts.event')

@section('content')

    <h3 class="mb-3">Банк тестового задания - <span class="mg-span-fz11">{{$test_curr->name}} ({{$test_curr->id}}) </span></h3>

    <div class="row">
        <div class="col-sm-5">
            <h5>Добавление темы </h5>

            <form action="/simple-test-system-question-theme/{{$test_curr->id}}" method="POST" id="question_theme" class="mb-3">
                @csrf
                <label for="question_theme_add">Добавление темы к вопросу</label>
                <input type="text" name="theme" class="form-control" placeholder="theeeme" id="question_theme_add">


                <h5 class="text-success mt-3"><?=session()->get('add_question_theme')?></h5>

                <div class="mt-3">
                    <button class="btn btn-success">Добавить тему</button>
                </div>
            </form>

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
            <h5 class="text-success"><?=session()->get('add_question_error')?></h5>

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
                        <h5 class="text-danger add_question_error_ajax"></h5>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-success ">Добавить вопрос</button>
                    </div>
                </form>
            </div>

            <script>
                $('#qtype_select_id').on('change', function (e) {
                    let qst_type = $(this).val();
                    qst_type *= 1;
                    //console.log('select changed: id='+ qst_type);
                    //console.log('select switched: '+qst_type);
                    $('.forms_for_qst_types form').addClass('d-none');
                    $("#question_type_1 input[name=question_type]").val(qst_type);
                    $('.add_question_success_ajax').html('');
                    switch (qst_type) {
                        case 1:
                            $('#question_type_1').removeClass('d-none');
                            break;
                        case 2:
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
                                location.reload();
                            } else {
                                $('.add_question_error_ajax').html(data.errors);
                                return false;
                            }
                        }
                    });

                });

            </script>

        </div>



        <div class="col-sm-7">
            <h5>Список вопросов</h5>

            <table class="table table-bordered table-striped">
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



        </div>

    </div>

@endsection