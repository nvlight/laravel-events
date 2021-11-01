@if($shorturls->count())
    @foreach($shorturls as $shorturl)
        <tr>
            <td>{{$shorturl->id}}</td>
            <td>{{$shorturl->description}}</td>
            <td>{{$shorturl->longurl}}</td>
            <td>
                <a href="{{ url('/su/'.$shorturl->shorturl) }}" target="_blank">{{$shorturl->shorturl}}</a>
                <br>
                <span>{{ url('/su/'.$shorturl->shorturl) }}</span>
            </td>
            <td class="td-btn-flex-1">

                <div class="view">
                    <button class="mg-btn-1" title="просмотреть">
                        <a href="/shorturl/{{$shorturl->id}}">
                            <svg height="22" viewBox="0 0 24 24" width="28" aria-hidden="true" class="mg-btn-show"><path fill-rule="evenodd" d="M8.954 17H2.75A1.75 1.75 0 011 15.25V3.75C1 2.784 1.784 2 2.75 2h18.5c.966 0 1.75.784 1.75 1.75v11.5A1.75 1.75 0 0121.25 17h-6.204c.171 1.375.805 2.652 1.769 3.757A.75.75 0 0116.25 22h-8.5a.75.75 0 01-.565-1.243c.964-1.105 1.598-2.382 1.769-3.757zM21.5 3.75v11.5a.25.25 0 01-.25.25H2.75a.25.25 0 01-.25-.25V3.75a.25.25 0 01.25-.25h18.5a.25.25 0 01.25.25zM13.537 17c.125 1.266.564 2.445 1.223 3.5H9.24c.659-1.055 1.097-2.234 1.223-3.5h3.074z"></path></svg>
                        </a>
                    </button>
                </div>

                <div class="edit">
                    <button class="mg-btn-1" title="редактировать">
                        <a href="/shorturl/{{$shorturl->id}}/edit">
                            <svg height="22" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true" class="mg-btn-edit"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
                        </a>
                    </button>
                </div>

                <div class="delete">
                    <form action="{{ route('shorturl.destroy', $shorturl->id) }}" class="shorturl-delete-button" method="POST" style="">
                        @csrf
                        @method('DELETE')
                        <button class="mg-btn-1 " type="submit" title="удалить">
                            <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="35" height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                        </button>
                    </form>
                </div>

            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td class="">Список пуст</td>
    </tr>
@endif
