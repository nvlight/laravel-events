<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel-Evento') }}</title>
    <link href="{{ asset('bootstrap-5.0.0-alpha2-dist/css/bootstrap.css') }}" rel="stylesheet">

    @stack('header_styles')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>

    <script src="{{ asset('bootstrap-5.0.0-alpha2-dist/js/bootstrap.js') }}"></script>

    @include('cabinet.evento._inner.footer')

    @stack('footer_js')
</body>
</html>