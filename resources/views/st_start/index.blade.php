@extends('layouts.test')

@section('content')

    <div id="mg_content">

        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <style>
                        /*@import url('https://fonts.googleapis.com/css?family=Nunito&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese');*/
                    </style>
                    <div class="sts_title m-b-md">
                        Система тестирования <span class="mg-span-betaVersion">(бета-версия)</span>
                    </div>

                    <?php
                    //dump($testCatsWithChildTestsGetFormatted);

                    ?>
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>shid</th>
                            <th>cat_id</th>
                            <th>test_id/<br>sel_nm<br>shedule_id</th>
                            <th>имя БТЗ/<br>выборка</th>
                            <th>имя ТЗ</th>
                            <th>кол-во вопросов/<br>длительность</th>
                            <th>действия</th>
                        </tr>
                        @foreach($testCatsWithChildTestsGetFormatted as $k => $v)

                            @foreach($v as $kk => $vv)

                                @foreach($vv as $kkk => $vvv)

                                    <tr>
                                        <td>{{$vvv['shedule_id']}}</td>
                                        <td>{{$vvv['category_id']}}</td>
                                        <td>{{$vvv['test_id']}}/{{$vvv['selected_qsts_number']}}/{{$vvv['shedule_id']}}</td>
                                        <td>{{$vvv['category']}} / {{$vvv['test']}}</td>
                                        <td>{{$vvv['selection_name']}}</td>
                                        <td>{{$vvv['qsts_count']}}/{{$vvv['selection_duration']}}</td>
                                        <td><a href="/tests/{{$vvv['shedule_id']}}">просмотреть</a></td>
                                    </tr>

                                @endforeach

                            @endforeach

                        @endforeach

                    </table>

                </div>

                </div>

            </div>
        </div>

    </div>

@endsection