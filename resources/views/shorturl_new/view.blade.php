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
                        @include('shorturl.table_shortUrls')
                    </td>
                </tr>
            </table>

            <div class="actions" style="display: flex; ">
                <div class="edit_btn">
                    @include('shorturl.buttons.edit_withText')
                </div>
                @include('shorturl.buttons.delete_withText')
            </div>

        </div>
    </div>

@endsection