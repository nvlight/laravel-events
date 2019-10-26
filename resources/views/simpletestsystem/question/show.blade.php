@extends('layouts.event')

@section('content')

    <h4><a href="/simple-test-system-question/<?=session()->get('tz')->id?>"><?=session()->get('tz')->name?></a></h4>

    <h5 class="mb-3">Просмотр вопроса</h5>

    <?php
    //echo App\Debug::d($question->toArray());
    ?>

    <table class="table table-striped table-striped table-responsive">
        <tr>
            <th>Ключ</th>
            <th>Значение</th>
        </tr>
        @foreach($question->toArray() as $k => $v)
            <tr>
                <td>{{$k}}</td>
                <td>{{$v}}</td>
            </tr>
        @endforeach
    </table>

@endsection