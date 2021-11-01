@extends('layouts.event')

@section('content')

    <a href="{{ route('shorturl.index') }}">Короткие ссылки</a>

    <div class="row">
        <div class="col-md-4">
            <h4>Просмотр</h4>

            <table class="table table-striped table-bordered table">
                <tr>
                    <td><strong>Описание</strong></td>
                    <td>{{ $shorturl->description }}</td>
                </tr>
                <tr>
                    <td><strong>Длинная ссылка</strong></td>
                    <td>{{ $shorturl->longurl }}</td>
                </tr>
                <tr>
                    <td><strong>Короткая ссылка</strong></td>
                    <td>
                        <a href="{{ url('/su/'.$shorturl->shorturl) }}" target="_blank">{{$shorturl->shorturl}}</a>
                        <br>
                        <span>{{ url('/su/'.$shorturl->shorturl) }}</span>
                    </td>
                </tr>
            </table>
            
            <div class="actions" style="display: flex; ">
                <div class="edit_btn">
                    <a href="{{ route('shorturl.edit', $shorturl->id) }}">
                        <button class="btn btn-primary" title="редактировать">Редактировать</button>
                    </a>
                </div>
                <form class="" action="/shorturl/{{$shorturl->id}}" method="POST" style="margin-left: 3px;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit" title="удалить">
                        Удалить
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection