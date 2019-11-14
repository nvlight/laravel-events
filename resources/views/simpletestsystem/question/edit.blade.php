@extends('layouts.event')

@section('content')

    <h4><a href="/sts-question/{{$question->id}}">Назад</a></h4>

    <h5 class="mb-3">Редактирование вопроса '<?=$question->description?>'</h5>

    <?php
    //echo \App\Debug::d($question_ids->toArray());
    $qst_ids = $question_ids->toArray();
    $question_description = '';
    ?>

    <div class="row">

        <div class="col-md-6">

            <div class="qst_change">
            <label class="mb-3 mt-3" for="question_description">Вопрос</label>

                @if(count($qst_ids))
                    @foreach($qst_ids as $k => $v)
                        @if($v['description_type'] === 1)
                            <?php $question_description = $v['id']; ?>
                            <form action="" class="mb-3 form_question_update">
                                @csrf
                                <input type="hidden" name="qst_id" value="{{$v['id']}}" class="">

                                <div class="position-relative">
                                    <input class="form-control " id="question_description" type="text" name="question_description" value="{{$v['description']}}">
                                    <div class="question_update_status d-none"></div>
                                    <span class="badge-success mt-2 p-2 question_update_span d-none">Обновлен</span>
                                </div>

                            </form>
                        @endif
                    @endforeach
                @endif

            </div>


            <h5 class="mb-3 mt-3">Варианты ответа</h5>

            @if(session()->has('del_question'))
                <h5 class="text-danger">{{session()->get('del_question')}}</h5>
            @endif

            @if(session()->has('add_questionAnswer'))
                <h5 class="text-success">{{session()->get('add_questionAnswer')}}</h5>
            @endif

            @if(session()->has('update_questionAnswer'))
                <h5 class="text-success">{{session()->get('update_questionAnswer')}}</h5>
            @endif

            <button id="addNewAnswer" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalAddNewAnswer">Добавить новый</button>

            <table class="table table-bordered table-striped table-responsive">
                <tr>
                    <th>#</th>
                    <th>description</th>
                    <th>desc_type</th>
                    <th>controls</th>
                </tr>
                @if(count($qst_ids))
                    @foreach($qst_ids as $k => $v)
                        @if($v['description_type'] !== 1)
                            <tr>
                                <td>{{$k}}</td>
                                <td>{{$v['description']}}</td>
                                @switch($v['description_type'])
                                    @case(2)
                                        <td>Правильный ответ</td>
                                        @break
                                    @case(3)
                                        <td>Неправильный ответ</td>
                                        @break
                                @endswitch
                                <td class="td-btn-flex-1">
                                    <form action="/sts-question/{{$v['id']}}" method="POST" id="editAnswer_{{$v['id']}}">
                                        <button class="mg-btn-1" type="submit" title="редактировать" data-target="addNewAnswer">
                                            <svg height="22" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true" class="mg-btn-edit"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
                                        </button>
                                    </form>
                                    <form action="/sts-question/{{$v['id']}}" class="shorturl-delete-button" method="POST" style="">
                                        @csrf
                                        @method('delete')
                                        <button class="mg-btn-1 " type="submit" title="удалить">
                                            <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </table>
        </div>

    </div>

    <!-- Modal addNewAnswer -->
    <div class="modal fade" id="modalAddNewAnswer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление нового варианта ответа</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_AddNewAnswer" action="/ccccdhiuc">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modalAddNewAnswer_description">Ответ</label>
                            <input class="form-control" type="text" id="modalAddNewAnswer_description" name="description" placeholder="Введите описание ответа">
                        </div>
                        <div class="mb-3">
                            <label for="modalAddNewAnswer_descriptionType">Тип ответа</label>
                            <select class="form-control" name="description_type" id="modalAddNewAnswer_descriptionType">
                                <option value="0">Выберите тип ответа</option>
                                <option value="2">Правильный ответ</option>
                                <option value="3">Неправильный ответ</option>
                            </select>
                        </div>
                        <div class="mb-3 errors">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal EditNewAnswer -->
    <div class="modal fade" id="modalEditAnswer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel_2">Редактирование варианта ответа</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form_EditAnswer" action="/ccccdhiuc">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modalEditAnswer_description">Ответ</label>
                            <input class="form-control" type="text" id="modalEditAnswer_description" name="description" placeholder="Введите описание ответа">
                        </div>
                        <input type="hidden" id="modalEditAnswer_id" value="">
                        <div class="mb-3">
                            <label for="modalEditAnswer_answerType">Тип ответа</label>
                            <select class="form-control" name="answerType" id="modalEditAnswer_answerType">
                                <option value="0">Выберите тип ответа</option>
                                <option value="2">Правильный ответ</option>
                                <option value="3">Неправильный ответ</option>
                            </select>
                        </div>
                        <div class="mb-3 errors ">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary">Обновить</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script>

        //$('#modalAddNewAnswer').modal();

        function reloadQuestionDescription(){
            $.ajax({
                type:'get',
                url:"/sts-question/<?=$question_description?>/get",
                data: '',
                beforeSend: function(){

                },
                success:function(data){
                    if (data.success === 1){
                        //console.log('okey');
                        $('#question_description').val(data.description);
                    }
                },
                error:function (e) {
                    $('input[name=question_description] + div ').addClass('d-none');
                }
            });
        };

        function deleteQuestionById(id){
            $.ajax({
                type:'delete',
                url:"/sts-question/"+id,
                data: '',
                beforeSend: function(){ },
                success:function(data){
                    if (data.success === 1){
                        console.log('success - deleteQuestionById');
                    }
                },
                error:function (e) {
                    console.log('error - deleteQuestionById');
                }
            });
        }

        reloadQuestionDescription();

        $('input[name=question_description]').on('keyup', function (e) {

            e.preventDefault();

            let new_question_description = $(this).val();

            //console.log(new_question_description);

            //
            function updateQuestionAnimation(){
                //console.log('im here');
                $('input[name=question_description] + div ').addClass('d-none');
            }

            //
            function showUpdateQuestionStatus(){
                if ( !$('.question_update_span').hasClass('badge-danger')){
                    $('.question_update_span').addClass('d-none');
                }else{
                    reloadQuestionDescription();
                    $('.question_update_span').addClass('d-none');
                }
            }

            $.ajax({
                type:'PATCH',
                url:'/sts-question-update-description',
                data: $('form.form_question_update').serialize(),
                beforeSend: function(){
                    //console.log('before send');
                    $('input[name=question_description] + div ').removeClass('d-none');
                    //setTimeout(function() {}, 1500);
                },
                success:function(data){
                    //console.log(data.message);
                    //$('input[name=question_description] + div ').addClass('d-none');
                    if (data.success === 1){
                        $('.question_update_span')
                            .removeClass('d-none')
                            .removeClass('badge-danger')
                            .addClass('badge-success')
                            .html(data['message']);
                    } else {
                        $('.question_update_span')
                            .addClass('badge-danger')
                            .removeClass('d-none')
                            .removeClass('badge-success')
                            .html(data['message']);
                    }
                    setTimeout(updateQuestionAnimation, 500);
                    setTimeout(showUpdateQuestionStatus, 2000);
                    //$('input[name=question_description] + div + div').removeClass('d-none');
                },
                error:function (e) {
                    $('input[name=question_description] + div ').addClass('d-none');
                }
            });

        });

        $('form#form_AddNewAnswer').submit(function (e) {
            e.preventDefault();

            $.ajax({
                type:'post',
                url:"/sts-question-add-answer/<?=$question_description?>",
                data: $(this).serialize(),
                beforeSend: function(){},
                success:function(data){
                    $('#form_AddNewAnswer .errors').html("");
                    switch (data.success) {
                        case 1:
                            location.reload();
                            break;
                        case 2:
                            var doConfirm = confirm(data.message);
                            console.log('confirm: '+doConfirm);

                            if (doConfirm){
                                $.ajax({
                                    type:'post',
                                    url:"/sts-question-add-answer-confirm/<?=$question_description?>",
                                    data: $('form#form_AddNewAnswer').serialize(),
                                    beforeSend: function(){},
                                    success:function(data){
                                        $('#form_AddNewAnswer .errors').html("");
                                        switch (data.success) {
                                            case 1:
                                                location.reload();
                                                break;
                                            case 0:
                                                for(var key in data.errors[0]){
                                                    $('#form_AddNewAnswer .errors').append("<div class='text-danger'><strong>"+data['errors'][0][key]+"</strong></div>")
                                                    //console.log(key + ' : ' + data['errors'][0][key])
                                                }
                                        }
                                    },
                                    error:function (e) {
                                        $('#form_AddNewAnswer .errors').html("");
                                        console.log('something gone wrong');
                                    }
                                });
                            }
                            break;
                        case 0:
                            for(var key in data.errors[0]){
                                $('#form_AddNewAnswer .errors').append("<div class='text-danger'><strong>"+data['errors'][0][key]+"</strong></div>")
                                //console.log(key + ' : ' + data['errors'][0][key])
                            }
                    }
                },
                error:function (e) {
                    $('#form_AddNewAnswer .errors').html("");
                    console.log('something gone wrong');
                }
            });
        });

        $('form[id^=editAnswer_]').submit(function (e) {
            e.preventDefault();

            let id = $(this).attr('id');
            id = id.replace('editAnswer_','');
            //console.log(id);
            $.ajax({
                type:'get',
                url:"/sts-question-get-answer/"+id,
                data: $(this).serialize(),
                beforeSend: function(){ },
                success:function(data){
                    if (data.success === 1){
                        $('#modalEditAnswer').modal();
                        $('#modalEditAnswer_id').val(data.data['id']);
                        $('#modalEditAnswer_description').val(data.data['description']);
                        $('#modalEditAnswer_answerType').find('option[value='+data.data['description_type'] +']').attr('selected','selected');
                    }else{
                        console.log('Что-то пошло не так!')
                    }
                },
                error:function (e) { console.log('something gone wrong') }
            });

        });

        $('#form_EditAnswer').submit(function (e) {
            e.preventDefault();
            //console.log('form_EditAnswer - stop ');
            var description = $('#modalEditAnswer_description').val();
            var answer_type = $('#modalEditAnswer_answerType :selected').val();
            var id = $('#modalEditAnswer_id').val();
            var dt = 'description=' + description + '&answer_type=' + answer_type;
            //let answer_type = ['answer_type'] = answer_type;
            //console.log(($(this).serialize()));
            //console.log(description + ' - ' + answer_type);
            $.ajax({
                type:'patch',
                url:"/sts-question-update-answer/"+id,
                data: $(this).serialize(),
                beforeSend: function(){ $('#form_EditAnswer .errors').html('') },
                success:function(data){
                    if (data.success === 1){
                        location.reload();
                    }else{
                        //console.log('Что-то пошло не так!')
                        for(var key in data.errors[0]){
                            $('#form_EditAnswer .errors').append("<div class='text-danger'><strong>"+data['errors'][0][key]+"</strong></div>")
                            //console.log(key + ' : ' + data['errors'][0][key])
                        }
                    }
                },
                error:function (e) { console.log('something gone wrong') }
            });
        });

    </script>

@endsection