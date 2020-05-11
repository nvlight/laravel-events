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
    <link rel="stylesheet" href="{{ asset('css/mgram/main.css')}}">
    <link rel="stylesheet" href="{{ asset('bootstrap-datepicker/bootstrap-datepicker.css')}}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('summernote/summernote-bs4.js') }}" ></script>
    <script src="{{ asset('bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('bootstrap-datepicker/bootstrap-datepicker.ru.min.js') }}" ></script>

    <link rel="stylesheet" href="{{asset('bootstrap-select-1.13.1/bootstrap-select.min.css')}}">
    <script src="{{ asset('bootstrap-select-1.13.1/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('js/common.js') }}" ></script>

</head>
<body>
<div id="app">

    <div id="mg_preload_wrapper">
        <div id="mg_preload" style="display: block;position: fixed;z-index: 999;top: 0;left: 0;right: 0; bottom: 0; width: 100%;height: 100%;background: #3B4453 url(/img/three-dots.svg) center center no-repeat;background-size:41px;">
        </div>
    </div>

    <div class="wrapper">

        <div class="copy">
                <div class="content-line">
                    @yield('content')
                </div>
            <div>
                <span>&copy; Martin German <?=Date('Y')?>. All rights reserved</span>
            </div>
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

$('#mg_preload').delay(150).fadeOut('slow');

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