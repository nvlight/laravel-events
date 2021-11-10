@extends('layouts.event')

@section('content')

    <a href="{{ route('shorturlnew_category.index') }}">Категория короткой ссылки</a>

    <div class="row">
        <div class="col-md-4">
            <h4>Просмотр</h4>

            <table class="table table-striped table-bordered table">
                <tr>
                    <td><strong>id</strong></td>
                    <td>{{ $category->id }}</td>
                </tr>
                <tr>
                    <td><strong>parent_id</strong></td>
                    <td>{{ $category->parent_id }}</td>
                </tr>
                <tr>
                    <td><strong>name</strong></td>
                    <td>{{ $category->name }}</td>
                </tr>
                <tr>
                    <td><strong>slug</strong></td>
                    <td>{{ $category->slug }}</td>
                </tr>
            </table>

            <div class="actions" style="display: flex; ">
                <span style="display: flex;">
                    @include('shorturl_new.buttons.view', ['item' => $category])
                    @include('shorturl_new.buttons.delete', ['item' => $category])
                </span>
            </div>

        </div>
    </div>

@endsection