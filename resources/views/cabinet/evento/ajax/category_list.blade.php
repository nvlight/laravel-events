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
            @php $i=0; @endphp
            @foreach($categories as $k => $v)
                <tr class="add-category--tr_id-{{{ $v['id'] }}}">
                    <td class="categoryId">{{ $v['id'] }}</td>
                    <td class="add-category-crud--name-field d-flex justify-content-between">
                        <div class="text">{{ $v['name'] }}</div>
                    </td>
                    <td>{{ $v['img'] }}</td>
                    <td>
                        {{-- <span href="" class="category-add--edit-button curp">edit</span> / --}}
                        <a href="/cabinet/evento/category/edit/now/{{ $v['id'] }}" data-categoryId="{{ $v['id'] }}" class="category_edit_for_crud">edit</a>
                        <a href="{{ route('cabinet.evento.category.destroy_ajax', $v) }}" class="category_delete_for_crud" data-id="{{$v['id']}}">delete</a>
                    </td>
                </tr>
                @php $i++; @endphp
            @endforeach
        </tbody>
    </table>
@endif