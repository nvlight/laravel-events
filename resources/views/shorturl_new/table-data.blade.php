@if( count($shortUrlsArrTree) )
    @php $offset = 0; $offsetInc = 3; $repeatStr = '-'; @endphp
    @foreach($shortUrlsArrTree as $k => $v)
        {{$v['id']}} {{$v['parent_id']}} {{$v['name']}}

        @if ( isset($v['child']) )
            @php $offset += $offsetInc; @endphp
            <br>

            @foreach($v['child'] as $kk => $vv)
                @php echo str_repeat($repeatStr, $offset) @endphp {{$vv['id']}} {{$vv['parent_id']}} {{$vv['name']}}
                <br>

                @if ( isset($vv['child']) )
                    @php $offset += $offsetInc; @endphp

                    @foreach($vv['child'] as $kkk => $vvv)
                        @php echo str_repeat($repeatStr, $offset) @endphp {{$vvv['id']}} {{$vvv['parent_id']}} {{$vvv['name']}}
                        <br>
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
