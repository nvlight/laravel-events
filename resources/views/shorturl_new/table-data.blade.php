@if( count($shortUrlsArrTree) )
    @php $offset = 0; $offsetInc = 3; $repeatStr = '-'; @endphp
    @foreach($shortUrlsArrTree as $k => $v)
        <div style="display: flex; align-items: center;" >
            {{$v['id']}} {{$v['parent_id']}} {{$v['name']}}
            <form action="{{ route('shorturlnew.destroy', $v['id']) }}" method="POST" class="shorturl-delete-button"  style="">
                @csrf
                @method('DELETE')
                <button class="mg-btn-1 " type="submit" title="удалить" >
                    <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-delete" width="20" height="20"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                </button>
            </form>
        </div>

        @if ( isset($v['child']) )
            @php $offset += $offsetInc; @endphp

            @foreach($v['child'] as $kk => $vv)
                <div>
                    @php echo str_repeat($repeatStr, $offset) @endphp {{$vv['id']}} {{$vv['parent_id']}} {{$vv['name']}}
                </div>

                @if ( isset($vv['child']) )
                    @php $offset += $offsetInc; @endphp

                    @foreach($vv['child'] as $kkk => $vvv)
                        <div>
                            @php echo str_repeat($repeatStr, $offset) @endphp {{$vvv['id']}} {{$vvv['parent_id']}} {{$vvv['name']}}
                        </div>
                    @endforeach

                    @php $offset -= $offsetInc; @endphp
                @endif

            @endforeach

            @php $offset -= $offsetInc; @endphp
        @endif
{{--                @include('shorturl_new.table_shortUrls')--}}
{{--                    @include('shorturl_new.buttons.view_withText')--}}
{{--                    @include('shorturl_new.buttons.edit_withIcon')--}}
{{--                    @include('shorturl_new.buttons.delete_withIcon')--}}


    @endforeach
@else
    <tr>
        <td class="">Список пуст</td>
    </tr>
@endif
