@extends('layouts.evento')

@section('content')
    <main>
        <div class="container">
            <h1 class="">Evento/index</h1>
            <p class="">
                <a class="" href="{{ route('cabinet.evento.create') }}">create new evento</a>
                <a class="" href="{{ route('cabinet.evento.category.index') }}">category/index</a>
                <a class="" href="{{ route('cabinet.evento.tag.index') }}">tag/index</a>
                <a class="" href="{{ route('cabinet.evento.eventocategory.index') }}">eventoCategory/index</a>
                <a class="" href="{{ route('cabinet.evento.eventotag.index') }}">eventoTag/index</a>
                <a class="" href="{{ route('cabinet.evento.eventotagvalue.index') }}">eventoTagValue/index</a>
                <a class="" href="{{ route('cabinet.evento.attachment.index') }}">attachment/index</a>
            </p>

            @if($eventosWithAllColumnsArrayFormatted)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover ">
                        <tr>
                            <th class="">#</th>
                            <th class="">Description</th>
                            <th class="">Date</th>
                            <th class="">categories</th>
                            <th class="">tags/vals/caps</th>
                            <th class="">actions</th>
                        </tr>
                        @foreach($eventosWithAllColumnsArrayFormatted as $eventoKey => $eventoId)
                            @foreach($eventoId as $categoryKey => $eventoCategoryId)
                                <tr>
                                    <td class="">{{$eventoCategoryId[0]['evento_id'] }}</td>
                                    <td class="">{{$eventoCategoryId[0]['evento_description'] }}</td>
                                    <td class="">{{$eventoCategoryId[0]['date'] }}</td>
                                    <td class="">{{$eventoCategoryId[0]['evento_category_name'] }}</td>

                                    <td class="">
                                        <div class="">
                                            @foreach($eventoCategoryId as $eventoTagId => $eventoTags)
                                                @php //dd($eventoCategoryId); @endphp

                                                <div class="lead d-flex mt-1" >
                                                    <small class="badge p-2" style="background-color: {{ $eventoTags['evento_tag_color'] }};">
                                                        <span class="">{{ $eventoTags['evento_tag_name'] }}</span>
                                                        @if ($eventoTags['evento_evento_tag_value_value'] !== null && $eventoTags['evento_evento_tag_value_value'] !== 0)
                                                            <span class="badge bg-secondary" role="button" >
                                                                {{ $eventoTags['evento_evento_tag_value_value'] }}
                                                            </span>
                                                        @endif
                                                    </small>
                                                </div>

                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="border px-4 py-2">
                                        @php //$fistCategoryForEventoId = array_key_first($eventoId); dd($eventoId[$fistCategoryForEventoId][0]['evento_id']); @endphp
                                        <?php //dd($eventoId); ?>
                                        <a href="{{ route('cabinet.evento.show',    $eventoKey ) }}" class="">show </a>
                                        <a href="{{ route('cabinet.evento.edit',    $eventoKey ) }}" class="">update </a>
                                        <a href="{{ route('cabinet.evento.destroy', $eventoKey ) }}" class="">delete </a>
                                        <a href="">add tag /</a>
                                        <a href="">add tagValue /</a>
                                        <a href="">add attachment /</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                </div>
            @endif

        </div>

    </main>

    <footer class="">
        <div class="container">
            <p class="">© <script>document.write(new Date().getFullYear())</script> Evento
            </p>
        </div>
    </footer>

    <script>
        var currentDeleteItemHref = null;
        let deleteItemA = document.querySelectorAll('a.deleteItem');
        if (deleteItemA.length){
            for (let i=0; i<deleteItemA.length; i++){
                deleteItemA[i].onclick = function (e) {
                    e.stopImmediatePropagation();
                    if (deleteItemA[i].hasAttribute('href')){
                        let href = deleteItemA[i].getAttribute('href');
                        currentDeleteItemHref = href;
                        //console.log(href);
                        dialogOpenBtnHandler();

                        let deleteConfirmBtn = document.querySelector('.deleteConfirmBtn');
                        if (deleteConfirmBtn){
                            deleteConfirmBtn.onclick = function () {
                                deleteConfirmBtnHandler(currentDeleteItemHref);
                            }
                        }
                    }
                    return false;
                }
            }
        }

        let openDeactivateDialog = document.querySelector('#openDeactivateDialog');
        if (openDeactivateDialog){
            openDeactivateDialog.addEventListener('click', dialogOpenBtnHandler)
        }

        let cancelBtn = document.querySelector('.cancelBtn');
        if (cancelBtn){
            cancelBtn.addEventListener('click', dialogCloseBtnHandler);
        }

        let closeMainDialogOnDarkSide = document.querySelector('#main_dialog');
        if (closeMainDialogOnDarkSide){
            closeMainDialogOnDarkSide.onclick = function(e) {
                //console.log(e.target.classList + ' clicked ' + Math.random(100));
                let targetClass = '#main_dialog';
                let isFindTarget = document.querySelector(targetClass);

                if (e.target.classList.contains('modalBg') && isFindTarget ){
                    isFindTarget.classList.toggle('d-none');
                }
            };
        }

        function dialogOpenBtnHandler() {
            let targetClass = '#main_dialog';
            let isFindTarget = document.querySelector(targetClass);
            if (isFindTarget){
                isFindTarget.classList.toggle('d-none');
            }
        }
        function dialogCloseBtnHandler() {
            let targetClass = '#main_dialog';
            let isFindTarget = document.querySelector(targetClass);
            if (isFindTarget){
                isFindTarget.classList.toggle('d-none');
            }
        }
        function deleteConfirmBtnHandler(href) {
            document.location.href = href;
        }

    </script>

@endsection