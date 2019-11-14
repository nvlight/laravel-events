@extends('layouts.event')

@section('content')

    <h5 class="mb-3">Просмотр темы '<?=$theme->description?>'</h5>

    <table class="table table-striped table-striped table-responsive">
        <tr>
            <th>Ключ</th>
            <th>Значение</th>
        </tr>
        @foreach($theme->toArray() as $k => $v)
            <tr>
                <td>{{$k}}</td>
                <td>{{$v}}</td>
            </tr>
        @endforeach
    </table>

    <a href="/sts-theme/{{$theme->id}}/edit" class="btn btn-primary">Редактировать</a>

@endsection