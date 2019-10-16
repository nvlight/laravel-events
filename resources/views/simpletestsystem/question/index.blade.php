@extends('layouts.event')

@section('content')

    <h3 class="mb-3">Банк тестового задания - <span class="mg-span-fz11">{{$test_curr->name}} ({{$test_curr->id}}) </span></h3>

    <div class="row">
        <div class="col-sm-6">
            <h5>Добавление вопроса</h5>

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

            <h5 class="text-success"><?=session()->get('add_question_success')?></h5>
            <h5 class="text-success"><?=session()->get('add_question_error')?></h5>

            <div class="mb-3 forms_for_qst_types">
                <form action="/simple-test-system-question" method="POST" id="question_type_1" class="d-none">
                    @csrf

                    <input type="hidden" name="parent_id" value="{{$test_curr->id}}">
                    <input type="hidden" name="question_type" value="0">

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

            <script>
                $('#qtype_select_id').on('change', function (e) {
                    let qst_type = $(this).val();
                    qst_type *= 1;
                    //console.log('select changed: id='+ qst_type);
                    //console.log('select switched: '+qst_type);
                    $('.forms_for_qst_types form').addClass('d-none');
                    $("#question_type_1 input[name=question_type]").val(qst_type);
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

                //
                function change_answer_state(e, th){

                }

            </script>

        </div>



        <div class="col-sm-6">
            <h5>Список вопросов</h5>

            @if($questions->count())
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>#</th>
                        <th>qst_type</th>
                        <th>description</th>
                        <th>desc_type</th>
                        <th>number</th>
                    </tr>
                    @foreach($questions as $question)
                        <tr>
                            <td>{{$question->number}}</td>
                            <td>{{$question->type}}</td>
                            <td>{{$question->description}}</td>
                            <td>{{$question->description_type}}</td>
                            <td>{{$question->number}}</td>
                        </tr>
                    @endforeach
                </table>
            @endif

        </div>

    </div>

@endsection