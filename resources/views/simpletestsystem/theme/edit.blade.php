@extends('layouts.event')

@section('content')

    <h4><a href="/simple-test-system-question/<?=session()->get('tz')->id?>">Банк ТЗ - '<?=session()->get('tz')->name?>'</a></h4>
    <h4><a href="/sts-theme/{{$theme->id}}">Назад</a></h4>

    <h5 class="mb-3">Редактирование темы '<?=$theme->description?>'</h5>

    <div class="row">
        <div class="col-md-4">
            <table class="table table-striped table-striped table-responsive">
                <form action="/sts-theme/{{$theme->id}}" class="form-control mb-3" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="theme">Название темы</label>
                        <input type="text" class="form-control" id="theme" name="theme" value="{{$theme->description}}">
                    </div>

                    <div class="mb-3">
                        @if(session()->get('theme_edit')['success'] === 1)
                            <h5 class="text-success">{{session()->get('theme_edit')['message']}}</h5>
                        @else
                            <h5 class="text-danger">{{session()->get('theme_edit')['message']}}</h5>
                        @endif
                    </div>

                    <button class="btn btn-primary">Сохранить</button>
                </form>

            </table>
        </div>
    </div>

@endsection