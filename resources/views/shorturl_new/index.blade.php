@extends('layouts.event')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-3">Короткие ссылки</h2>
            <a href="{{ route('event.index') }}">Главная</a>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <h4>Список коротких ссылок</h4>
            <h5 class="text-success"><?=session()->get('shorturl_deleted')?></h5>
            <h5 class="text-success"><?=session()->get('shorturl_created')?></h5>
            <h5 class="text-success"><?=session()->get('shorturl_updated')?></h5>

            <div>
                @include('shorturl_new.table-data')
            </div>

        </div>

    </div>

@endsection