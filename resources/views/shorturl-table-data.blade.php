@if($shorturls->count())
    @foreach($shorturls as $shorturl)
        <tr>
            <td>{{$shorturl->id}}</td>
            <td>{{$shorturl->description}}</td>
            <td>{{$shorturl->longurl}}</td>
            <td>
                <a href="{{url('/su/'.$shorturl->shorturl)}}">{{$shorturl->shorturl}}</a>
                <br>
                <span>{{url('/su/'.$shorturl->shorturl)}}</span>
            </td>
            <td class="td-btn-flex-1">
                <form action="/shorturl/{{$shorturl->id}}/edit" method="GET" style="">
                    <button class="mg-btn-1" type="submit" title="редактировать">
                        <a href="/shorturl/{{$shorturl->id}}/edit">
                            <svg height="22" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true" class="mg-btn-edit"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
                        </a>
                    </button>
                </form>

                <form action="/shorturl/{{$shorturl->id}}" class="shorturl-delete-button" method="POST" style="">
                    @csrf
                    @method('DELETE')
                    <button class="mg-btn-1 " type="submit" title="удалить">
                        <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                    </button>
                </form>

            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td class="">Список пуст</td>
    </tr>
@endif
