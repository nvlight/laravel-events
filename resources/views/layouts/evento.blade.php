<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel-Evento') }}</title>

    <link href="{{ asset('bootstrap-5.0.0-alpha2-dist/css/bootstrap.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        @yield('content')
    </div>

    <script src="{{ asset('bootstrap-5.0.0-alpha2-dist/js/bootstrap.js') }}"></script>

    <script src="{{ asset('js/evento.main.js') }}"></script>

    <footer class="">
        <div class="container">
            <p class="">© <script>document.write(new Date().getFullYear())</script> Evento
            </p>
        </div>
    </footer>
</body>
</html>