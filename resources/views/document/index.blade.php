@extends('layouts.event')

@section('content')

    <h3>Документы</h3>

    <h5 class="mt-3">Загрузка документов</h5>
    <h5 class="text-success"><?=session()->get('document_uploaded');?></h5>
    <h5 class="text-success"><?=session()->get('document_deleted');?></h5>
    <div class="row">
        <div class="col-sm-6">
            <form class="form" action="{{ URL::to('/document') }}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="form-group">
                    {{--                    <label for="uploadFile">Example file input</label>--}}
                    <input type="file" class="form-control-file" name="uploadFile">
                </div>
                <button type="submit" class="btn btn-primary">Загрузить</button>
            </form>
        </div>

        <div class="col-sm-6">
            <form class="form" action="{{ URL::to('/document') }}" method="GET" enctype="multipart/form-data" >
                <div class="form-group">
                    <label for="filename1">Имя файла</label>
                    <input type="text" class="form-control" id="filename1" name="filename" placeholder="поиск самого интересного файла!" value="{{$filename}}">
                </div>
                @if ($docVld->fails())
                    <?php //dd($docVld->errors()->all()); ?>
                    <ul class="notification text-danger text-center">
                        @foreach ($docVld->errors()->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                @endif
                <button type="submit" class="btn btn-primary">Искать</button>
                <a href="/document" class="btn btn-danger">Сброс</a>
            </form>
        </div>
    </div>

    <h5 class=" mt-3">Список документов</h5>
    <table class="table table-striped table-bordered table-responsive">
        <tr>
            <th>#</th>
            <th>Имя</th>
            <th>Объем</th>
            <th>actions</th>
        </tr>

            @foreach($documents as $document)
                <tr>
                    <td>{{$document->id}}</td>
                    <td>{{$document->filename}}</td>
                    <td>{{$document->size}}</td>
                    <td class="td-btn-flex-1">

                        <form action="/document-download/{{$document->id}}" method="GET" style="">
                            <button class="mg-btn-1" type="submit" title="скачать">
                                <svg height="32" class="mg-document-svg-download" viewBox="0 0 16 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M4 6h3V0h2v6h3l-4 4-4-4zm11-4h-4v1h4v8H1V3h4V2H1c-.55 0-1 .45-1 1v9c0 .55.45 1 1 1h5.34c-.25.61-.86 1.39-2.34 2h8c-1.48-.61-2.09-1.39-2.34-2H15c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1z"></path></svg>
                            </button>
                        </form>

                        <form action="/document/{{$document->id}}" class="mg-document-delete"  method="POST" style="">
                            @csrf
                            @method('DELETE')
                            <button class="mg-btn-1" type="submit" title="удалить">
                                <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach


    </table>



@endsection