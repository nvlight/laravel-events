<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

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

<header id="mg_header">
    <div class="mg_header_inner">
        <div class="mg_events_mainLink">
            <a href="/">Events</a>
        </div>

        <div class="d-flex flex-row justify-content-end">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/tests') }}">tests</a>
                        <a href="{{ url('/event') }}">events</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

</header>

<style>
    html,
    body {
        height: 100%;
    }
    .wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }
    .content {
        flex: 1 0 auto;
    }
    .footer {
        flex: 0 0 auto;
    }
</style>

<div class="wrapper">

    <div class="content">
        @yield('content')
    </div>

    <div class="footer">
        <footer id="mg_footer" class="">
            <nav id="mg_footer_inner">
                <div class="copyright text-center">
                    &copy; <?=date('Y')?> Martin German. All rights reserved.
                </div>

            </nav>
        </footer>
    </div>
</div>

</body>
</html>
