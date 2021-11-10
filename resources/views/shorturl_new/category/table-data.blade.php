@if( count($shortUrlsArrTree) )
    @php $offset = 0; $offsetInc = 3; $repeatStr = '-'; @endphp
    @foreach($shortUrlsArrTree as $k => $v)
        <div style="display: flex; align-items: center;" >
            @include('shorturl_new.blocks.category', ['item' => $v, 'repeatStr' => $repeatStr, 'offset' => $offset ])
        </div>

        @if ( isset($v['child']) )
            @php $offset += $offsetInc; @endphp

            @foreach($v['child'] as $kk => $vv)
                <div style="display: flex; align-items: center;" >
                    @include('shorturl_new.blocks.category', ['item' => $vv, 'repeatStr' => $repeatStr, 'offset' => $offset ])
                </div>

                @if ( isset($vv['child']) )
                    @php $offset += $offsetInc; @endphp

                    @foreach($vv['child'] as $kkk => $vvv)
                        <div style="display: flex; align-items: center;" >
                            @include('shorturl_new.blocks.category', ['item' => $vvv, 'repeatStr' => $repeatStr, 'offset' => $offset ])
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
