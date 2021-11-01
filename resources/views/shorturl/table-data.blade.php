@if($shorturls->count())
    @foreach($shorturls as $shorturl)
        <tr>
            <td>{{$shorturl->id}}</td>
            <td>{{$shorturl->description}}</td>
            <td>{{$shorturl->longurl}}</td>
            <td>
                @include('shorturl.table_shortUrls')
            </td>
            <td class="td-btn-flex-1">

                <div class="view">
                    @include('shorturl.buttons.view_withText')
                </div>
                <div class="edit">
                    @include('shorturl.buttons.edit_withIcon')
                </div>
                <div class="delete">
                    @include('shorturl.buttons.delete_withIcon')
                </div>

            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td class="">Список пуст</td>
    </tr>
@endif
