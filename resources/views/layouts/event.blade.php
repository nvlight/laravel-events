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
    <script src="{{ asset('js/common.js') }}" ></script>
</head>
<body>
<div id="app">

    <?php
    //echo Debug::d(Yii::$app->db);
    ?>

    <div id="hellopreloader">
        <div id="hellopreloader_preload" style="display: block;position: fixed;z-index: 999;top: 0;left: 0;right: 0; bottom: 0; width: 100%;height: 100%;background: #3B4453 url(/img/three-dots.svg) center center no-repeat;background-size:41px;">
        </div>
    </div>

    <?php
        $mainMenuSVGclass1 = 'main-menu-svg-class-1';
        $mainMenuData = [
            [
                'url' => 'exchange-rate',
                'title' => 'Курсы валют',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" class="octicon octicon-book __SVG_REPLACE_CLASS__" viewBox="0 0 16 16" version="1.1" width="32" aria-hidden="true"><path fill-rule="evenodd" d="M3 5h4v1H3V5zm0 3h4V7H3v1zm0 2h4V9H3v1zm11-5h-4v1h4V5zm0 2h-4v1h4V7zm0 2h-4v1h4V9zm2-6v9c0 .55-.45 1-1 1H9.5l-1 1-1-1H2c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1h5.5l1 1 1-1H15c.55 0 1 .45 1 1zm-8 .5L7.5 3H2v9h6V3.5zm7-.5H9.5l-.5.5V12h6V3z"></path></svg>'
            ],
            [
                'url' => 'event',
                'title' => 'События',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" class="octicon octicon-megaphone __SVG_REPLACE_CLASS__" viewBox="0 0 16 16" version="1.1" width="32" aria-hidden="true"><path fill-rule="evenodd" d="M10 1c-.17 0-.36.05-.52.14C8.04 2.02 4.5 4.58 3 5c-1.38 0-3 .67-3 2.5S1.63 10 3 10c.3.08.64.23 1 .41V15h2v-3.45c1.34.86 2.69 1.83 3.48 2.31.16.09.34.14.52.14.52 0 1-.42 1-1V2c0-.58-.48-1-1-1zm0 12c-.38-.23-.89-.58-1.5-1-.16-.11-.33-.22-.5-.34V3.31c.16-.11.31-.2.47-.31.61-.41 1.16-.77 1.53-1v11zm2-6h4v1h-4V7zm0 2l4 2v1l-4-2V9zm4-6v1l-4 2V5l4-2z"></path></svg>'
            ],
            [
                'url' => 'youtube',
                'title' => 'Youtube',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" class="octicon octicon-play __SVG_REPLACE_CLASS__" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M14 8A7 7 0 1 1 0 8a7 7 0 0 1 14 0zm-8.223 3.482l4.599-3.066a.5.5 0 0 0 0-.832L5.777 4.518A.5.5 0 0 0 5 4.934v6.132a.5.5 0 0 0 .777.416z"></path></svg>'
            ],

            //
            [
                'url' => 'document',
                'title' => 'Документы',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" class="octicon octicon-file-submodule __SVG_REPLACE_CLASS__" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M10 7H4v7h9c.55 0 1-.45 1-1V8h-4V7zM9 9H5V8h4v1zm4-5H7V3c0-.66-.31-1-1-1H1c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h2V7c0-.55.45-1 1-1h6c.55 0 1 .45 1 1h3V5c0-.55-.45-1-1-1zM6 4H1V3h5v1z"></path></svg>'
            ],

            [
                'url' => 'shorturl',
                'title' => 'Goo.gl',
                'svg_class_1' => $mainMenuSVGclass1,
                'svg' => '<svg height="32" width="28" class="octicon octicon-code __SVG_REPLACE_CLASS__" viewBox="0 0 14 16" version="1.1" aria-hidden="true"><path fill-rule="evenodd" d="M9.5 3L8 4.5 11.5 8 8 11.5 9.5 13 14 8 9.5 3zm-5 0L0 8l4.5 5L6 11.5 2.5 8 6 4.5 4.5 3z"></path></svg>'
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
                            <?php
                            //echo \App\Debug::d($mainMenuData); die;
                            ?>
                            <ul class="list-unstyled mainul">
                                <?php $active_count = 0; ?>
                                <?php foreach ($mainMenuData as $menuKey => $menu): ?>
                                <?php if (1==1): ?>
                                <?php
//                                    'url' => 'exchange-rate',
//                                    'title' => 'Курсы валют',
//                                    'svg_class' => '',
//                                    'svg' => ''
                                ?>
                                <li>
                                    <a href="{{url($menu['url'])}}">
                                        <?=$menu['svg']?><span class="text">{{$menu['title']}}</span>
                                    </a>
                                </li>
                                <?php else: ?>

                                <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                            <?php //echo Debug::d($st,'st'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 mp0">
                    <div class="contentbar">
                        <?php
                        ?>
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
                                            {{ Auth::user()->name }}
                                        </strong>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu " aria-labelledby="dropdownMenu1" >
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
