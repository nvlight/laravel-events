@if($tags)
    <table class="table table-bordered table-striped">
        <caption style="caption-side: top">Tag CRUD</caption>
        <thead>
            <tr>
                <td>#</td>
                <td>name</td>
                <td>img</td>
                <td>color</td>
                <td>action</td>
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @foreach($tags as $k => $v)
                <tr class="add-tag--tr_id-{{{ $v['id'] }}}">
                    <td class="tagId">{{ $v['id'] }}</td>
                    <td class="add-tag-crud--name-field d-flex justify-content-between">
                        <div class="text">{{ $v['name'] }}</div>
                    </td>
                    <td>{{ $v['img'] }}</td>
                    <td>{{ $v['color'] }}</td>
                    <td><span href="" class="tag-add--edit-button curp">edit</span> /<a href="{{ route('cabinet.evento.tag.destroy_ajax', $v) }}" class="tag_delete_for_crud" data-id="{{$v['id']}}">delete</a></td>
                </tr>
                @php $i++; @endphp
            @endforeach
        </tbody>
    </table>
@endif