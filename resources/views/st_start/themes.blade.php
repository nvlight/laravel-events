@extends('layouts.test_geek1')

@section('content')

    <link href="{{ asset('css/geek_test/test_detail/vendor.0d5f9223a1f958d314fb.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/geek_test/test_detail/vendor.0d5f9223a1f958d314fb.css') }}" rel="stylesheet" media="all">

    <div class="page-content">
        <div class="gb-test-page">
            <div class="gb-test-page__left test-control">
                <img src="/{{$testBreadCrumbs->first()->img}}" alt="">
                <form action="/tests/start" method="POST">
                    @csrf
                    <input type="hidden" name="shedules_id" value="{{$shedule_id->id}}">
                    <div class="mg_start_test_button">
                        <button class="test-control__button js-show-popup" href="">Начать тест →</button>
                    </div>
                </form>

                <p class="test-control__login-inf login-inf"><span class="login-inf__txt">Необходимо</span> <a class="login-inf__link" href="/login">войти</a> <span class="login-inf__txt">или</span> <a class="login-inf__link" href="https://geekbrains.ru/register">зарегистрироваться</a> <span class="login-inf__txt">чтобы пройти тест.</span></p>
                <div class="test-control__retry-interval">Интервал попыток 1 день</div>
            </div>
            <div class="gb-test-page__right">
                <div class="test-inf">
                    <div class="test-inf__header header">
                        <div class="header__title">Тест по {{$testBreadCrumbs->first()->category}}.  {{$testBreadCrumbs->first()->test_name}}</div>
                        <div class="header__description">{{$testBreadCrumbs->first()->category}}.  {{$testBreadCrumbs->first()->test_name}} ({{$shedule_id->name}}) </div>
                        <div class="header__complexity complexity">
                            <div class="complexity__title">Сложность:</div>
                            <div id="difficulty" class="complexity__rate" data-difficulty="5" title="gorgeous"><i class="fa fa-fw fa-star" title="gorgeous" data-score="1"></i>&nbsp;<i class="fa fa-fw fa-star" title="gorgeous" data-score="2"></i>&nbsp;<i class="fa fa-fw fa-star" title="gorgeous" data-score="3"></i>&nbsp;<i class="fa fa-fw fa-star" title="gorgeous" data-score="4"></i>&nbsp;<i class="fa fa-fw fa-star" title="gorgeous" data-score="5"></i><input type="hidden" name="score" value="5" readonly="readonly"></div>
                        </div>
                    </div>
                    <div class="test-inf__body body">
                        <div class="body__item statistics">
                            <div class="statistics__item statistics-item"><img title="Необходимо для успешного прохождения" class="statistics-item__img" src="https://d3ur190xygwd69.cloudfront.net/assets/tests/icon_42-ee494322f2d82797e2954905baea0f7d9aa1273911e6cc4db620457080a61a02.png" alt="Icon 42" />
                                <div class="statistics-item__data"><span class="statistics-item__txt_color_green">{{ ($shedule_id->qsts_count - 5) }}</span> <span class="statistics-item__txt"> из {{$shedule_id->qsts_count}}</span></div><small>вопросы</small>
                            </div>
                            <div class="statistics__item statistics-item"><img class="statistics-item__img" src="https://d3ur190xygwd69.cloudfront.net/assets/tests/icon_36-837a23d7de241900c23d9ebfcc22193083852eea51de615490f31e5978f6f13b.png" alt="Icon 36" />
                                <div class="statistics-item__data"><span class="statistics-item__txt">{{$shedule_id->duration}} минут</span></div><small>время на тест</small>
                            </div>
                            <div class="statistics__item statistics-item"><img class="statistics-item__img" src="https://d3ur190xygwd69.cloudfront.net/assets/tests/icon_45-466c53ccd549979592d8142c0de07d99273211fa2d99796ee4efae042ab8b496.png" alt="Icon 45" />
                                <div class="statistics-item__data"><span class="statistics-item__txt">1 день</span></div><small>интервал попыток</small>
                            </div>
                            <div class="statistics__item statistics-item"><img class="statistics-item__img" src="https://d3ur190xygwd69.cloudfront.net/assets/tests/icon_47-095ede7c6b342029efc093f721b2abb13b61f177a0a0b18e8ca54afa8fb5d2cc.png" alt="Icon 47" />
                                <div class="statistics-item__data"><span class="statistics-item__txt">{{$testSuccessCompletedCount}} чел.</span></div><small>прошли тест</small>
                            </div>
                        </div>
                        <div class="body__item topics">
                            <div class="topics__title">Темы тестирования</div>

                            @if(count($theme_ids))
                                <ul class="topics__list topics-list">
                                    @foreach($theme_ids as $theme)
                                        <li class="topics-list__item">{{$theme['description']}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="test-passed-list">
                    <div class="test-passed-list__counter">Тест прошли {{$testSuccessCompletedCount}} человек</div>
                    <div class="test-passed-list__title">Последние прошедшие:</div>
                    <ul class="test-passed-list__list passed-list">
                        <li class="passed-list__item passed-list-item">
                            <div class="passed-list-item__left"><a class="passed-list-item__img-wrapper" href="/users_tests/1540926"><img class="passed-list-item__img" src="/testCategoriesImg/anonymous.png" alt="Anonymous" /></a>
                                <div class="passed-list-item__user-inf"><a class="passed-list-item__user-name" href="/users_tests/1540926">Ирина Волосевич</a><span class="passed-list-item__user-passed-time"><i></i> 1 день назад</span></div>
                            </div>
                            <div class="passed-list-item__right points"><span class="point_state_passed">27</span> <span>/</span> <span>30</span></div>
                        </li>
                        <li class="passed-list__item passed-list-item">
                            <div class="passed-list-item__left"><a class="passed-list-item__img-wrapper" href="/users_tests/3444967"><img class="passed-list-item__img" src="/testCategoriesImg/anonymous.png" alt="Anonymous" /></a>
                                <div class="passed-list-item__user-inf"><a class="passed-list-item__user-name" href="/users_tests/3444967">Аноним</a><span class="passed-list-item__user-passed-time"><i></i> 3 дня назад</span></div>
                            </div>
                            <div class="passed-list-item__right points"><span class="point_state_passed">26</span> <span>/</span> <span>30</span></div>
                        </li>
                        <li class="passed-list__item passed-list-item">
                            <div class="passed-list-item__left"><a class="passed-list-item__img-wrapper" href="/users_tests/512717"><img class="passed-list-item__img" src="/testCategoriesImg/anonymous.png" alt="Anonymous" /></a>
                                <div class="passed-list-item__user-inf"><a class="passed-list-item__user-name" href="/users_tests/512717">Дмитрий Гетта</a><span class="passed-list-item__user-passed-time"><i></i> 4 дня назад</span></div>
                            </div>
                            <div class="passed-list-item__right points"><span class="point_state_passed">25</span> <span>/</span> <span>30</span></div>
                        </li>
                        <li class="passed-list__item passed-list-item">
                            <div class="passed-list-item__left"><a class="passed-list-item__img-wrapper" href="/users_tests/3956933"><img class="passed-list-item__img" src="/testCategoriesImg/anonymous.png" alt="Anonymous" /></a>
                                <div class="passed-list-item__user-inf"><a class="passed-list-item__user-name" href="/users_tests/3956933">Станислав Веселов</a><span class="passed-list-item__user-passed-time"><i></i> 8 дней назад</span></div>
                            </div>
                            <div class="passed-list-item__right points"><span class="point_state_passed">27</span> <span>/</span> <span>30</span></div>
                        </li>
                        <li class="passed-list__item passed-list-item">
                            <div class="passed-list-item__left"><a class="passed-list-item__img-wrapper" href="/users_tests/3937301"><img class="passed-list-item__img" src="/testCategoriesImg/anonymous.png" alt="Anonymous" /></a>
                                <div class="passed-list-item__user-inf"><a class="passed-list-item__user-name" href="/users_tests/3937301">Станислав Веселов</a><span class="passed-list-item__user-passed-time"><i></i> 9 дней назад</span></div>
                            </div>
                            <div class="passed-list-item__right points"><span class="point_state_passed">25</span> <span>/</span> <span>30</span></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

