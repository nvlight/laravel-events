@if($eventos)
    <div class="controls d-flex justify-content-around">
        <p>Evento count: {{ $eventoCount }}</p>
    </div>
    <div class="table-responsive">
        <table class="eventos_table table table-bordered table-striped ">
            <thead>
                @include('cabinet.evento._inner.list.header')
            </thead>
            @foreach($eventos as $eventoKey => $evento)
                @include('cabinet.evento._inner.list.item')
            @endforeach
        </table>
    </div>
@endif

</div>