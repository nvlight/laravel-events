@if( count($shortUrlsArrTree) )
    @php $offset = 0; $offsetInc = 3; $repeatStr = '-'; @endphp
    @foreach($shortUrlsArrTree as $k => $v)
        <div>
            {{$v['id']}} {{$v['parent_id']}} {{$v['name']}} <a href="">Delete</a>
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
