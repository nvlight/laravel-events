<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel-Evento') }}</title>

</head>
<body>
<div id="app">

    <div class="wrapper">
        <div class="container">
            <div class="content-line">
                @yield('content')
            </div>
        </div>
        <div class="copy">
            <span>
                &copy; Martin German <?=Date('Y')?>. All rights reserved
            </span>
        </div>
    </div>

</div>
</body>
</html>