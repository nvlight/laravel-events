<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('bootstrap-datepicker/bootstrap-datepicker.css')}}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('summernote/summernote-bs4.js') }}" ></script>
    <script src="{{ asset('bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('bootstrap-datepicker/bootstrap-datepicker.ru.min.js') }}" ></script>

{{--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">--}}
{{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>--}}

    <link rel="stylesheet" href="{{asset('bootstrap-select-1.13.1/bootstrap-select.min.css')}}">
    <script src="{{ asset('bootstrap-select-1.13.1/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('js/common.js') }}" ></script>

</head>
<body>
<div id="app">

    <?php

    ?>

    <div id="hellopreloader">
        <div id="hellopreloader_preload" style="display: block;position: fixed;z-index: 999;top: 0;left: 0;right: 0; bottom: 0; width: 100%;height: 100%;background: #3B4453 url(/img/three-dots.svg) center center no-repeat;background-size:41px;">
        </div>
    </div>

    <?php
        $mainMenuSVGclass1 = 'main-menu-svg-class-1';
        $mainMenuData = [
            [
                'role' => 'user',
                'url' => 'exchange-rate',
                'title' => 'Курсы валют',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" class="octicon octicon-book __SVG_REPLACE_CLASS__" viewBox="0 0 16 16" version="1.1" width="32" aria-hidden="true"><path fill-rule="evenodd" d="M3 5h4v1H3V5zm0 3h4V7H3v1zm0 2h4V9H3v1zm11-5h-4v1h4V5zm0 2h-4v1h4V7zm0 2h-4v1h4V9zm2-6v9c0 .55-.45 1-1 1H9.5l-1 1-1-1H2c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1h5.5l1 1 1-1H15c.55 0 1 .45 1 1zm-8 .5L7.5 3H2v9h6V3.5zm7-.5H9.5l-.5.5V12h6V3z"></path></svg>'
            ],
            [
                'role' => 'user',
                'url' => 'event',
                'title' => 'События',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" class="octicon octicon-megaphone __SVG_REPLACE_CLASS__" viewBox="0 0 16 16" version="1.1" width="32" aria-hidden="true"><path fill-rule="evenodd" d="M10 1c-.17 0-.36.05-.52.14C8.04 2.02 4.5 4.58 3 5c-1.38 0-3 .67-3 2.5S1.63 10 3 10c.3.08.64.23 1 .41V15h2v-3.45c1.34.86 2.69 1.83 3.48 2.31.16.09.34.14.52.14.52 0 1-.42 1-1V2c0-.58-.48-1-1-1zm0 12c-.38-.23-.89-.58-1.5-1-.16-.11-.33-.22-.5-.34V3.31c.16-.11.31-.2.47-.31.61-.41 1.16-.77 1.53-1v11zm2-6h4v1h-4V7zm0 2l4 2v1l-4-2V9zm4-6v1l-4 2V5l4-2z"></path></svg>'
            ],
            [
                'role' => 'user',
                'url' => 'youtube_search',
                'title' => 'Youtube',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" class="octicon octicon-play __SVG_REPLACE_CLASS__" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M14 8A7 7 0 1 1 0 8a7 7 0 0 1 14 0zm-8.223 3.482l4.599-3.066a.5.5 0 0 0 0-.832L5.777 4.518A.5.5 0 0 0 5 4.934v6.132a.5.5 0 0 0 .777.416z"></path></svg>'
            ],

            //
            [
                'role' => 'user',
                'url' => 'document',
                'title' => 'Документы',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" class="octicon octicon-file-submodule __SVG_REPLACE_CLASS__" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M10 7H4v7h9c.55 0 1-.45 1-1V8h-4V7zM9 9H5V8h4v1zm4-5H7V3c0-.66-.31-1-1-1H1c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h2V7c0-.55.45-1 1-1h6c.55 0 1 .45 1 1h3V5c0-.55-.45-1-1-1zM6 4H1V3h5v1z"></path></svg>'
            ],

            [
                'role' => 'user',
                'url' => 'shorturl',
                'title' => 'Goo.gl',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" width="28" class="octicon octicon-code __SVG_REPLACE_CLASS__" viewBox="0 0 14 16" version="1.1" aria-hidden="true"><path fill-rule="evenodd" d="M9.5 3L8 4.5 11.5 8 8 11.5 9.5 13 14 8 9.5 3zm-5 0L0 8l4.5 5L6 11.5 2.5 8 6 4.5 4.5 3z"></path></svg>'
            ],

            [
                'role' => 'admin',
                'url' => 'simple-test-system',
                'title' => 'SimpleTestSystem',
                'svg_class_1' => $mainMenuSVGclass1,
                //'svg' => '<svg height="32" width="28" class="octicon octicon-mortar-board __SVG_REPLACE_CLASS__" viewBox="0 0 14 16" version="1.1" aria-hidden="true"><path fill-rule="evenodd" d="M8.11 2.8a.34.34 0 0 0-.2 0L.27 5.18a.35.35 0 0 0 0 .67L2 6.4v1.77c-.3.17-.5.5-.5.86 0 .19.05.36.14.5-.08.14-.14.31-.14.5v2.58c0 .55 2 .55 2 0v-2.58c0-.19-.05-.36-.14-.5.08-.14.14-.31.14-.5 0-.38-.2-.69-.5-.86V6.72l4.89 1.53c.06.02.14.02.2 0l7.64-2.38a.35.35 0 0 0 0-.67L8.1 2.81l.01-.01zM4 8l3.83 1.19h-.02c.13.03.25.03.36 0L12 8v2.5c0 1-1.8 1.5-4 1.5s-4-.5-4-1.5V8zm3.02-2.5c0 .28.45.5 1 .5s1-.22 1-.5-.45-.5-1-.5-1 .22-1 .5z"></path></svg>'
                'svg' => '<svg height="32" width="28" class="octicon octicon-mortar-board main-menu-svg-class-1" viewBox="0 0 14 16" version="1.1" aria-hidden="true"><path fill-rule="evenodd" d="M8.11 2.8a.34.34 0 0 0-.2 0L.27 5.18a.35.35 0 0 0 0 .67L2 6.4v1.77c-.3.17-.5.5-.5.86 0 .19.05.36.14.5-.08.14-.14.31-.14.5v2.58c0 .55 2 .55 2 0v-2.58c0-.19-.05-.36-.14-.5.08-.14.14-.31.14-.5 0-.38-.2-.69-.5-.86V6.72l4.89 1.53c.06.02.14.02.2 0l7.64-2.38a.35.35 0 0 0 0-.67L8.1 2.81l.01-.01zM4 8l3.83 1.19h-.02c.13.03.25.03.36 0L12 8v2.5c0 1-1.8 1.5-4 1.5s-4-.5-4-1.5V8zm3.02-2.5c0 .28.45.5 1 .5s1-.22 1-.5-.45-.5-1-.5-1 .22-1 .5z"></path></svg>',
            ],

            [
                'role' => 'user',
                'url' => 'hd_video',
                'title' => 'HD Video',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" width="28" class="octicon device-camera-video __SVG_REPLACE_CLASS__" enable-background="new 0 0 24 24"version="1.1" viewBox="0 0 24 24" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path clip-rule="evenodd" d="M22.506,21v0.016L17,15.511V19c0,1.105-0.896,2-2,2h-1.5H3H2c-1.104,0-2-0.895-2-2  v-1l0,0V6l0,0V5c0-1.104,0.896-1.999,2-1.999h1l0,0h10.5l0,0H15c1.104,0,2,0.895,2,1.999v3.516l5.5-5.5V3.001  c0.828,0,1.5,0.671,1.5,1.499v15C24,20.327,23.331,20.996,22.506,21z" fill-rule="evenodd"/></svg>',
            ],

        ];
        foreach($mainMenuData as &$menu)
            if (array_key_exists('svg_class_1', $menu))
                $menu['svg'] = str_replace('__SVG_REPLACE_CLASS__',$menu['svg_class_1'],$menu['svg']);
        unset($menu); // !
        //echo \App\Debug::d($mainMenuData); die;
        ?>

    <div class="wrapper">
        <div class="container1">
            <div class="row mp0">
                <div class="col-md-2 mp0 hidden-sm hidden-xs">
                    <div class="leftbar">
                        <div class="caption ">
                            <a href="/">
                                <svg height="32" class="octicon octicon-globe main-logo-svg" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M7 1C3.14 1 0 4.14 0 8s3.14 7 7 7c.48 0 .94-.05 1.38-.14-.17-.08-.2-.73-.02-1.09.19-.41.81-1.45.2-1.8-.61-.35-.44-.5-.81-.91-.37-.41-.22-.47-.25-.58-.08-.34.36-.89.39-.94.02-.06.02-.27 0-.33 0-.08-.27-.22-.34-.23-.06 0-.11.11-.2.13-.09.02-.5-.25-.59-.33-.09-.08-.14-.23-.27-.34-.13-.13-.14-.03-.33-.11s-.8-.31-1.28-.48c-.48-.19-.52-.47-.52-.66-.02-.2-.3-.47-.42-.67-.14-.2-.16-.47-.2-.41-.04.06.25.78.2.81-.05.02-.16-.2-.3-.38-.14-.19.14-.09-.3-.95s.14-1.3.17-1.75c.03-.45.38.17.19-.13-.19-.3 0-.89-.14-1.11-.13-.22-.88.25-.88.25.02-.22.69-.58 1.16-.92.47-.34.78-.06 1.16.05.39.13.41.09.28-.05-.13-.13.06-.17.36-.13.28.05.38.41.83.36.47-.03.05.09.11.22s-.06.11-.38.3c-.3.2.02.22.55.61s.38-.25.31-.55c-.07-.3.39-.06.39-.06.33.22.27.02.5.08.23.06.91.64.91.64-.83.44-.31.48-.17.59.14.11-.28.3-.28.3-.17-.17-.19.02-.3.08-.11.06-.02.22-.02.22-.56.09-.44.69-.42.83 0 .14-.38.36-.47.58-.09.2.25.64.06.66-.19.03-.34-.66-1.31-.41-.3.08-.94.41-.59 1.08.36.69.92-.19 1.11-.09.19.1-.06.53-.02.55.04.02.53.02.56.61.03.59.77.53.92.55.17 0 .7-.44.77-.45.06-.03.38-.28 1.03.09.66.36.98.31 1.2.47.22.16.08.47.28.58.2.11 1.06-.03 1.28.31.22.34-.88 2.09-1.22 2.28-.34.19-.48.64-.84.92s-.81.64-1.27.91c-.41.23-.47.66-.66.8 3.14-.7 5.48-3.5 5.48-6.84 0-3.86-3.14-7-7-7L7 1zm1.64 6.56c-.09.03-.28.22-.78-.08-.48-.3-.81-.23-.86-.28 0 0-.05-.11.17-.14.44-.05.98.41 1.11.41.13 0 .19-.13.41-.05.22.08.05.13-.05.14zM6.34 1.7c-.05-.03.03-.08.09-.14.03-.03.02-.11.05-.14.11-.11.61-.25.52.03-.11.27-.58.3-.66.25zm1.23.89c-.19-.02-.58-.05-.52-.14.3-.28-.09-.38-.34-.38-.25-.02-.34-.16-.22-.19.12-.03.61.02.7.08.08.06.52.25.55.38.02.13 0 .25-.17.25zm1.47-.05c-.14.09-.83-.41-.95-.52-.56-.48-.89-.31-1-.41-.11-.1-.08-.19.11-.34.19-.15.69.06 1 .09.3.03.66.27.66.55.02.25.33.5.19.63h-.01z"></path></svg>
                                <span>{{ config('app.name', 'Laravel') }}</span>
                            </a>
                        </div>
                        <div class="main-menu">
                            @php $active_count = 0; @endphp
                            <ul class="list-unstyled mainul">
                                @php $active_count = 0; @endphp

                                @foreach ($mainMenuData as $menuKey => $menu)
                                    @if (Auth::user()->isAdmin())
                                        <li>
                                            <a href="{{url($menu['url'])}}">
                                                <?=$menu['svg']?><span class="text">{{$menu['title']}}</span>
                                            </a>
                                        </li>
                                    @elseif(Auth::user()->isUser() && $menu['role'] === Auth::user()::ROLE_USER)
                                        <li>
                                            <a href="{{url($menu['url'])}}">
                                                <?=$menu['svg']?><span class="text">{{$menu['title']}}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            @php $active_count = 0; @endphp
                        </div>
                    </div>
                </div>
                <div class="col-md-10 mp0">
                    <div class="contentbar">

                        @php
                        @endphp
{{--                        {{ dump(Auth::user()) }}--}}

                        <div class="user-line">
                            <div class="curr-date">
								<span>
									<?= date('d.m.Y')?>
								</span>
                            </div>
                            <div class="user-info">

                                <div class="dropdown">
                                    <a href="<?='/user/account'?>"
                                       class="btn btn-default dropdown-toggle gg-dropdown" type="button" id="dropdownMenu1"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <strong>
                                            @if(Auth::user() != null)
                                                {{Auth::user()->name}}
                                            @else
                                                UndefinedUser
                                            @endif
                                        </strong>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu " aria-labelledby="dropdownMenu1" >

                                        @if (Auth::user()->isAdmin())
                                            <li>
                                                <a class="dropdown-item" href="<?="/admin"?>">
                                                    <svg class="octicon octicon-three-bars user-sign-svg-1"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="24" height="32"><g id="admin"><path d="M58,36h-.08A6.74,6.74,0,0,0,58,35a7.008,7.008,0,0,0-7-7,6.626,6.626,0,0,0-5.29,2.67A6.262,6.262,0,0,0,43,30a5.987,5.987,0,0,0-4.07,1.6,15.371,15.371,0,0,0-2.1-.85A10.01,10.01,0,0,0,42,22a3.009,3.009,0,0,0,3-3V18a3.009,3.009,0,0,0-3-3v-.28A6.981,6.981,0,0,0,45,9V3a1,1,0,0,0-1-1H26a7.008,7.008,0,0,0-7,7v3a4.008,4.008,0,0,0,1.73,3.29A3,3,0,0,0,19,18v1a3.009,3.009,0,0,0,3,3,10.01,10.01,0,0,0,5.17,8.75,16.066,16.066,0,0,0-10.66,11.3A6.42,6.42,0,0,0,13,41a7.008,7.008,0,0,0-7,7,6.74,6.74,0,0,0,.08,1H6a4,4,0,0,0,0,8H20.41A15.98,15.98,0,0,0,48,46a16.515,16.515,0,0,0-.14-2H58a4,4,0,0,0,0-8ZM40.63,35a13.562,13.562,0,0,1-1.54,1.06,14.094,14.094,0,0,0-1.75-2.99A13.869,13.869,0,0,1,40.63,35ZM33,45V39.95a15.549,15.549,0,0,0,4.97-1.11,24.274,24.274,0,0,1,1,6.16Zm5.97,2a24.274,24.274,0,0,1-1,6.16A15.549,15.549,0,0,0,33,52.05V47ZM37.29,36.96a13.9,13.9,0,0,1-4.29.99V32.17C34.69,32.68,36.2,34.44,37.29,36.96ZM43,18v1a1,1,0,0,1-1,1V17A1,1,0,0,1,43,18ZM22,20a1,1,0,0,1-1-1V18a1,1,0,0,1,1-1Zm0-7v.72A2,2,0,0,1,21,12V9a5,5,0,0,1,5-5H43V9a4.971,4.971,0,0,1-1.28,3.32.942.942,0,0,0-.46-.28L35.62,10.5a.983.983,0,0,0-1.11.44,4.643,4.643,0,0,1-1.12,1.27,5.479,5.479,0,0,1-2.28.99A7.362,7.362,0,0,0,32,10.09,1,1,0,0,0,31,9H30a1.006,1.006,0,0,0-.39.08l-7,3A1,1,0,0,0,22,13Zm4.66,20.07a14.094,14.094,0,0,0-1.75,2.99A13.562,13.562,0,0,1,23.37,35,13.869,13.869,0,0,1,26.66,33.07Zm-4.78,3.29a16.344,16.344,0,0,0,2.31,1.59A25.732,25.732,0,0,0,23.03,45H18.05A13.924,13.924,0,0,1,21.88,36.36ZM6,55a2,2,0,0,1,0-4H7.35a1.028,1.028,0,0,0,.82-.42,1.01,1.01,0,0,0,.12-.91A5.2,5.2,0,0,1,8,48a5,5,0,0,1,5-5,4.532,4.532,0,0,1,3.1,1.27A16.562,16.562,0,0,0,16,46a15.924,15.924,0,0,0,2.78,9Zm12.05-8h4.98a25.732,25.732,0,0,0,1.16,7.05,16.344,16.344,0,0,0-2.31,1.59A13.924,13.924,0,0,1,18.05,47Zm5.32,10a13.562,13.562,0,0,1,1.54-1.06,14.094,14.094,0,0,0,1.75,2.99A13.869,13.869,0,0,1,23.37,57ZM31,59.83c-1.69-.51-3.2-2.27-4.29-4.79A13.9,13.9,0,0,1,31,54.05Zm0-7.78a15.549,15.549,0,0,0-4.97,1.11,24.274,24.274,0,0,1-1-6.16H31ZM31,45H25.03a24.274,24.274,0,0,1,1-6.16A15.549,15.549,0,0,0,31,39.95Zm0-7.05a13.9,13.9,0,0,1-4.29-.99c1.09-2.52,2.6-4.28,4.29-4.79ZM24,22V13.66l5.79-2.48a2.818,2.818,0,0,1-.52,1.14,5.038,5.038,0,0,1-.52.45,1.389,1.389,0,0,0-.7,1.53,1.332,1.332,0,0,0,.95.86,7.2,7.2,0,0,0,5.6-1.36,6.336,6.336,0,0,0,1.18-1.19L40,13.76V22a8,8,0,0,1-16,0Zm9,37.83V54.05a13.9,13.9,0,0,1,4.29.99C36.2,57.56,34.69,59.32,33,59.83Zm4.34-.9a14.094,14.094,0,0,0,1.75-2.99A13.562,13.562,0,0,1,40.63,57,13.869,13.869,0,0,1,37.34,58.93Zm4.78-3.29a16.344,16.344,0,0,0-2.31-1.59A25.732,25.732,0,0,0,40.97,47h4.98A13.924,13.924,0,0,1,42.12,55.64ZM40.97,45a25.732,25.732,0,0,0-1.16-7.05,16.344,16.344,0,0,0,2.31-1.59A13.924,13.924,0,0,1,45.95,45ZM58,42H47.47a16.017,16.017,0,0,0-6.64-9.33A3.942,3.942,0,0,1,43,32a4.4,4.4,0,0,1,2.42.82,1,1,0,0,0,.79.16,1.055,1.055,0,0,0,.65-.46A4.831,4.831,0,0,1,51,30a5,5,0,0,1,5,5,5.2,5.2,0,0,1-.29,1.67,1.01,1.01,0,0,0,.12.91,1.028,1.028,0,0,0,.82.42H58a2,2,0,0,1,0,4Z"/><rect x="15" y="18" width="2" height="2"/><path d="M9,20h4V18H8a1,1,0,0,0-1,1V39H9Z"/><rect x="47" y="18" width="2" height="2"/><path d="M55,27h2V19a1,1,0,0,0-1-1H51v2h4Z"/></g></svg>
                                                    {{ __('Админка') }}
                                                </a>
                                            </li>
                                        @endif

                                        <li>
                                            <a class="dropdown-item" href="<?="/user/change-user-info"?>">
                                                <svg height="32" class="octicon octicon-three-bars user-sign-svg-1" viewBox="0 0 12 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M11.41 9H.59C0 9 0 8.59 0 8c0-.59 0-1 .59-1H11.4c.59 0 .59.41.59 1 0 .59 0 1-.59 1h.01zm0-4H.59C0 5 0 4.59 0 4c0-.59 0-1 .59-1H11.4c.59 0 .59.41.59 1 0 .59 0 1-.59 1h.01zM.59 11H11.4c.59 0 .59.41.59 1 0 .59 0 1-.59 1H.59C0 13 0 12.59 0 12c0-.59 0-1 .59-1z"></path></svg>
                                                {{ __('Редактирование') }}
                                            </a>
                                        </li>
                                        <li role="separator" class="divider"></li>

                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                <svg height="32" class="octicon octicon-sign-out user-sign-svg-1" viewBox="0 0 16 16" version="1.1" width="32" aria-hidden="true"><path fill-rule="evenodd" d="M12 9V7H8V5h4V3l4 3-4 3zm-2 3H6V3L2 1h8v3h1V1c0-.55-.45-1-1-1H1C.45 0 0 .45 0 1v11.38c0 .39.22.73.55.91L6 16.01V13h4c.55 0 1-.45 1-1V8h-1v4z"></path></svg>
                                                {{ __('Выйти') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="content-line">
                            @yield('content')
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="copy">
		<span>
			&copy; Martin German <?=Date('Y')?>. All rights reserved
		</span>
        </div>
    </div>

    <div ><i class="fa fa-chevron-up"></i></div>

    <a id="go_to_top" style="display: none;" href="#" onclick="return false;" class="js-zc-conditional" data-clipboard-text="">
        <svg height="32" class="octicon octicon-chevron-up" viewBox="0 0 10 16" version="1.1" width="20" aria-hidden="true"><path fill-rule="evenodd" d="M10 10l-1.5 1.5L5 7.75 1.5 11.5 0 10l5-5 5 5z"></path></svg>
    </a>

    <?php
    $js1 = <<<JS

$(window).scroll(function(){
if ($(this).scrollTop() > 200) {
$('#go_to_top').fadeIn();
} else {
$('#go_to_top').fadeOut();
}
});

$('#go_to_top').click(function(){
$("html, body").animate({ scrollTop: 0 }, 0);
    return false;
});

$('#hellopreloader_preload').delay(150).fadeOut('slow');

$('.delete-event-by-id, .shorturl-delete-button, .mg-document-delete, .delete-event-category-byId, .delete-event-type-byId')
.submit(function (el) {
   console.log('before del element');
   if (!confirm('Удалить выделенный элемент?')) return false;
});

$('[class^=amount-computed]').on('keyup', function(e) {
  let parent_tr = $(this).parent().parent();
  let value = parent_tr.find('.Value').text();
  let nominal = parent_tr.find('.Nominal').text();
  let computed = ( (value * 1) / (nominal * 1) ) * ( $(this).val() * 1);
  parent_tr.find('.exchange-rate-result').val(computed.toFixed(2));
  console.log(value + ' : ' + nominal + ' --- ' + computed.toFixed(2));
});

JS;
    $css = <<<CSS
body{
    opacity: 1;
}
CSS;

    ?>
    <script>
        <?=$js1?>
    </script>

</div>
</body>
</html>