<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('bootstrap-5.0.0-beta2-dist/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Scripts -->

</head>
<body>
<div id="app">

    <div class="wrapper">

        <h3>Learn / main</h3>

        <div class="copy">
            <div class="content-line">
                @yield('content')
            </div>
            <div>
                <span>&copy; Martin German <?=Date('Y')?>. All rights reserved</span>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('bootstrap-5.0.0-beta2-dist/js/bootstrap.js') }}"></script>

</div>
</body>
</html>