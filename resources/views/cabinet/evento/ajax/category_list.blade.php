@if($categories)
    <table class="table table-bordered table-striped">
        <caption style="caption-side: top">Category CRUD</caption>
        <thead>
            <tr>
                <td>#</td>
                <td>name</td>
                <td>img</td>
                <td>action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $k => $v)
                <tr>
                    <td>{{ $v['id'] }}</td>
                    <td>{{ $v['name'] }}</td>
                    <td>{{ $v['img'] }}</td>
                    <td>edit/<a href="{{ route('cabinet.evento.category.destroy_ajax', $v) }}" class="category_delete_for_crud" data-id="{{$v['id']}}">delete</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif