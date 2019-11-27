@extends('layouts.event')

@section('content')

    <?php
    //echo \App\Debug::d($events);
    ?>
    <h3>События. Главная страница</h3>

    <div class="row">
        <div class="col-md-12">


            <div class="events-add-actions-before-table">
                <div><span>Список событий</span></div>
                <div class="events-right-actions">

                    <a href="/events-graphics" class="mg-event-add-a" title="графики событий">
                        <svg height="32" class="octicon octicon-project mg-event-add-a-svg" viewBox="0 0 15 16" version="1.1" width="30" aria-hidden="true"><path fill-rule="evenodd" d="M10 12h3V2h-3v10zm-4-2h3V2H6v8zm-4 4h3V2H2v12zm-1 1h13V1H1v14zM14 0H1a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h13a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1z"></path></svg>
                    </a>

                    <a href="/category" class="mg-event-add-a" title="создание категории или типа события">
                        <svg height="32" class="octicon octicon-repo-template mg-event-add-a-svg" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M12 8V1c0-.55-.45-1-1-1H1C.45 0 0 .45 0 1v12c0 .55.45 1 1 1h2v2l1.5-1.5L6 16v-4H3v1H1v-2h7v-1H2V1h9v7h1zM4 2H3v1h1V2zM3 4h1v1H3V4zm1 2H3v1h1V6zm0 3H3V8h1v1zm6 3H8v2h2v2h2v-2h2v-2h-2v-2h-2v2z"></path></svg>
                    </a>

                    <a href="/event/create" class="mg-event-add-a" title="создание нового события">
                        <svg height="32" class="octicon octicon-plus mg-event-add-a-svg" viewBox="0 0 12 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"></path></svg>
                    </a>
                    <a href="/event-filter" class="mg-event-add-a" title="фильтр событий">
                        <svg height="32" class="octicon octicon-clippy mg-event-add-a-svg" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M2 13h4v1H2v-1zm5-6H2v1h5V7zm2 3V8l-3 3 3 3v-2h5v-2H9zM4.5 9H2v1h2.5V9zM2 12h2.5v-1H2v1zm9 1h1v2c-.02.28-.11.52-.3.7-.19.18-.42.28-.7.3H1c-.55 0-1-.45-1-1V4c0-.55.45-1 1-1h3c0-1.11.89-2 2-2 1.11 0 2 .89 2 2h3c.55 0 1 .45 1 1v5h-1V6H1v9h10v-2zM2 5h8c0-.55-.45-1-1-1H8c-.55 0-1-.45-1-1s-.45-1-1-1-1 .45-1 1-.45 1-1 1H3c-.55 0-1 .45-1 1z"></path></svg>
                    </a>
                </div>
            </div>

            <h5 class="text-success"><?=session()->get('event_created');?></h5>
            <h5 class="text-success"><?=session()->get('event_deleted');?></h5>
            <h5 class="text-success"><?=session()->get('event_updated');?></h5>
            <table class="table table-bordered table-striped table-responsive">
                <tr>
                    <th>№</th>
                    <th>Категория</th>
                    <th>Описание</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Действия</th>
                </tr>

                @include('events-table-data')

            </table>

            {{$events->links()}}

        </div>

    </div>

@endsection