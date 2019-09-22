@extends('layouts.event')

@section('content')

    <?php
    //echo \App\Debug::d($events);
    //echo \App\Debug::d($categories);
    //echo \App\Debug::d($types);
    ?>

    <div class="row">
        <div class="col-md-12">
            <h3>Графики для событий</h3>
            <a href="/event">Список событий</a>
            <div id="chart2"></div>
            <div id="chart1"></div>

            {!! $chart2 !!}
            {!! $chart1 !!}
        </div>
    </div>

@endsection