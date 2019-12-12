@extends('layouts.test_geek1')

@section('content')


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

        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/15/image/831b1bd59854a25f3725b82510cbf98a.png"
                                             alt="831b1bd59854a25f3725b82510cbf98a"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Основы программирования</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/16">Начальный
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/107/image/603151473f0772e9a6535767bc876ea5.png"
                                             alt="603151473f0772e9a6535767bc876ea5"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Факультет дизайна</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/180">Дизайн-мышление</a>
                    </li>
                    <li class="levels__item level"><a class="level__link" href="/tests/179">Основы
                            визуального восприятия</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/105/image/227fedd690ca334cab5fd0880fc21e40.png"
                                             alt="227fedd690ca334cab5fd0880fc21e40"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Разработка игр</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/176">Основы
                            геймдизайна</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/168">Unity
                            AR/VR</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/1/image/1de72c2f8f0c919be8b1d257046bf489.png"
                                             alt="1de72c2f8f0c919be8b1d257046bf489"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">PHP</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/166">Тест
                            «PHP. Уровень 1»</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/19">Начальный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/1">Средний
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/30">Спортивный
                            тест</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/43">Сложный
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/68/image/77f483eaffdfed24cf07847ed90a5881.png"
                                             alt="77f483eaffdfed24cf07847ed90a5881"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Unity 3D</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/111">Unity.
                            Уровень 1</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/70/image/b8e768f983bf5a5c73ef1e379a15238d.png"
                                             alt="B8e768f983bf5a5c73ef1e379a15238d"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Информационная безопасность</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/157">Server
                            Side: часть 1</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/117">Веб-технологии:
                            уязвимости и безопасность</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/167">Бинарные
                            уязвимости</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/118">Client
                            Side уязвимости</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/175">Криптография</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/30/image/71dbf7038305e032c15f1665a4576e55.png"
                                             alt="71dbf7038305e032c15f1665a4576e55"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Django</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/68">Django</a>
                    </li>
                    <li class="levels__item level"><a class="level__link" href="/tests/106">Django
                            2</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/2/image/71eaa30cf7b60a60f2785373c2582363.png"
                                             alt="71eaa30cf7b60a60f2785373c2582363"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">HTML&amp;CSS</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/2">Начальный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/169">Тест
                            «HTML5/CSS3»</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/17">Средний
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/42">Сложный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/31">Спортивный
                            тест</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/3/image/bbabf696a8dd09f6aa746dfdeedcc4bc.png"
                                             alt="Bbabf696a8dd09f6aa746dfdeedcc4bc"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">JavaScript</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/21">Начальный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/174">Средний
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/15">Сложный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/35">Спортивный
                            тест</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/4/image/cc3c93017b18912c5e2a85111794ec70.png"
                                             alt="Cc3c93017b18912c5e2a85111794ec70"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Python</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/71">Начальный
                            уровень </a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/161">Регулярные
                            выражения и ООП в Python</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/151">Python
                            для Data Science </a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/152">Python.
                            Уровень 1</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/67">Средний
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/25">Спортивный
                            тест</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/5/image/58cc3e17b7d1c114ddffb9599ba8fe8c.png"
                                             alt="58cc3e17b7d1c114ddffb9599ba8fe8c"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Java</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/39">Начальный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/64">Java
                            EE</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/55">Средний
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/26">Спортивный
                            тест</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/58">Сложный
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/6/image/4f4f0b8a5d0453fe21336dae56d8df63.png"
                                             alt="4f4f0b8a5d0453fe21336dae56d8df63"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">C#</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/20">Начальный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/160">C#.
                            Уровень 1</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/7">Средний
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/33">Спортивный
                            тест</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/7/image/e9ce93c85a07ca9411792cc92a0043a4.png"
                                             alt="E9ce93c85a07ca9411792cc92a0043a4"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Photoshop</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/8">Начальный
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/8/image/9bb551f28a76fd091dfe78b0b8e5cf8b.png"
                                             alt="9bb551f28a76fd091dfe78b0b8e5cf8b"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Веб-дизайн</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/13">Начальный
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/9/image/244d780471e51b6c6093e9f8599bd0ee.png"
                                             alt="244d780471e51b6c6093e9f8599bd0ee"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">C++</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/154">ИК
                            С ++ Уровень 1</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/40">Начальный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/32">Средний
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/6">Сложный
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/10/image/11ce97c0386e387e56b0262d3ec1bf21.png"
                                             alt="11ce97c0386e387e56b0262d3ec1bf21"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Android</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/107">Android.
                            Material Design</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/34">Средний
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/11/image/225de66b480b2befc12685e25af53131.png"
                                             alt="225de66b480b2befc12685e25af53131"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Objective C</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/22">Начальный
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/12/image/320eb587a02e74912e3410c5fcb0acb0.png"
                                             alt="320eb587a02e74912e3410c5fcb0acb0"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Linux</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/110">Начальный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/57">Средний
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/13/image/c8b27613f7a7c94ec856be58d3f93920.png"
                                             alt="C8b27613f7a7c94ec856be58d3f93920"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Ruby on Rails</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/24">Начальный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/37">Средний
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/16/image/86229b1f901aacb424b0348e013582c2.png"
                                             alt="86229b1f901aacb424b0348e013582c2"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Tarantool</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/28">Tarantool</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/25/image/c5aea68726461acf76a36d2839f4b89b.png"
                                             alt="C5aea68726461acf76a36d2839f4b89b"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Swift</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/47">Основы
                            языка Swift</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/70">Введение
                            в IOS-разработку на Swift</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/69">Ускорение
                            IOS-приложений</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/26/image/13c77ee021b546aa2e30bc18d0c857f2.png"
                                             alt="13c77ee021b546aa2e30bc18d0c857f2"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Английский язык</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/48">Pre-intermediate</a>
                    </li>
                    <li class="levels__item level"><a class="level__link" href="/tests/49">Intermediate</a>
                    </li>
                    <li class="levels__item level"><a class="level__link" href="/tests/50">Upper-intermediate</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/28/image/dc7112b87e7f3dc99640b6f6895f509f.png"
                                             alt="Dc7112b87e7f3dc99640b6f6895f509f"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Базы данных</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/52">MySql</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/29/image/1b61dc162a5555b300df644c1460f940.png"
                                             alt="1b61dc162a5555b300df644c1460f940"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Тестирование ПО</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/165">Автоматизация
                            тестирования</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/53">Начальный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/60">Средний
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/31/image/aaeeb9bfda8d5a25bd992324f63cf165.png"
                                             alt="Aaeeb9bfda8d5a25bd992324f63cf165"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Алгоритмы и структуры данных</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/63">Алгоритмы
                            и структуры данных на PHP</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/61">На
                            языке Си</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/153">Алгоритмы
                            и структуры данных на Python</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/32/image/f252dc67736c2c29c4bd3106d449ef68.png"
                                             alt="F252dc67736c2c29c4bd3106d449ef68"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">ASP.Net Core MVC</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/109">ASP.Net
                            Core MVC 2</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/62">Начальный
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/33/image/d303cc56c6338d04c922b64669712564.png"
                                             alt="D303cc56c6338d04c922b64669712564"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">SMM</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/65">Стратегия</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/34/image/09264cc4f3ed4319038874fda4dbf61f.png"
                                             alt="09264cc4f3ed4319038874fda4dbf61f"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Spring Framework</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/66">Начальный
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/19/image/32cef0eabeb24b1b088a8cfe50c3f4aa.png"
                                             alt="32cef0eabeb24b1b088a8cfe50c3f4aa"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">C</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/164">Тест
                            на знание основ математики</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/158">Основы
                            языка C</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/173">Алгоритмы
                            и структуры данных на C</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/29">Средний
                            уровень </a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/22/image/484fb3583b6802f10bd6375a0bd78f6d.png"
                                             alt="484fb3583b6802f10bd6375a0bd78f6d"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">myTarget</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/41">Начальный
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/23/image/502ce058ebd61e1247c3a2d2df1b5edb.png"
                                             alt="502ce058ebd61e1247c3a2d2df1b5edb"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Компьютерные сети</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/72">Начальный
                            уровень</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/170">Компьютерные
                            сети</a></li>
                    <li class="levels__item level"><a class="level__link" href="/tests/73">Средний
                            уровень</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/24/image/0e441817b1bfc2a197b08950d610474c.png"
                                             alt="0e441817b1bfc2a197b08950d610474c"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Операционные системы</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/46">Основы
                            операционных систем</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d3ur190xygwd69.cloudfront.net/images/anonymous.png"
                                             alt="Anonymous"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Маркетинг для предпринимателей</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/187">Итоговый
                            тест</a></li>
                </ul>
            </div>
        </div>
        <div class="gb-tests-index__item test-card">
            <div class="test-card__img"><img width="80"
                                             src="https://d2xzmw6cctk25h.cloudfront.net/category/67/image/5155ece60f5c921c03a04f643230f7df.png"
                                             alt="5155ece60f5c921c03a04f643230f7df"/></div>
            <div class="test-card__inf">
                <div class="test-card__name">Ruby</div>
                <ul class="test-card__levels levels">
                    <li class="levels__item level"><a class="level__link" href="/tests/108">Ruby</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@endsection