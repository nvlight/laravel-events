@extends('layouts.test_geek1')

@section('content')

    <link href="{{ asset('css/geek_test/test_detail/vendor.0d5f9223a1f958d314fb.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/geek_test/test_detail/app.4bc4dbb916729b5c2908.css') }}" rel="stylesheet" media="all">

    <div class="container d-none" >
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

    <div class="gb-tests-index">

        @foreach($testCategoriesWithChilds as $categoryKey => $categoryValue)

            <div class="gb-tests-index__item test-card">
                <div class="test-card__img"><img width="80"
                                                 src="{{$categoryValue[0]['category_img']}}"
                                                 alt="831b1bd59854a25f3725b82510cbf98a"/></div>
                <div class="test-card__inf">
                    <div class="test-card__name">{{$categoryKey}}</div>

                    <ul class="test-card__levels levels">
                        @foreach($categoryValue as $childTests)
                            <li class="levels__item level"><a class="level__link" href="/tests/{{$childTests['shedule_id']}}">{{$childTests['test']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

        @endforeach

    </div>

@endsection