@extends('layouts.event')

@section('content')

    @if($ytVideoId)
        <h3>YouTube - show player with static video_id: {{$ytVideoId}}</h3>
    @endif

    <div class="row">
        @if($ytVideoId)
            <div>
                <iframe width="560" height="315"
                    src="https://www.youtube.com/embed/{{$ytVideoId}}"
                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                </iframe>
            </div>
            <div>
                <?php
                    $video = $jsonData->items[0];
                    $snippet = $video->snippet;
                    //echo \App\Models\MGDebug::d($video);
                ?>
                <table class="table table-bordered table-striped table-responsive">
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>etag</td>
                        <td>{{$video->etag}}</td>
                    </tr>
                    <tr>
                        <td>id</td>
                        <td>{{$video->id}}</td>
                    </tr>
                    <tr>
                        <td>publishedAt</td>
                        <td>{{$snippet->publishedAt}}</td>
                    </tr>
                    <tr>
                        <td>channelId</td>
                        <td>{{$snippet->channelId}}</td>
                    </tr>
                    <tr>
                        <td>title</td>
                        <td>{{$snippet->title}}</td>
                    </tr>
                    <tr>
                        <td>description</td>
                        <td>
                            <textarea class="" name="" id="" cols="30" rows="10">{{$snippet->description}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>channelTitle</td>
                        <td>{{$snippet->channelTitle}}</td>
                    </tr>

                    <?php
                        //echo \App\Models\MGDebug::d($video->contentDetails);
                        //dump($video->contentDetails);
                    ?>

                    <tr>
                        <td colspan="2"><strong>contentDetails</strong></td>
                    </tr>

                    <tr>
                        <td>
                            @php
                                //echo \App\Models\MGDebug::d($video->contentDetails);
                            @endphp
                        </td>
                    </tr>

                    @foreach($video->contentDetails as $k => $v)
                        @if($k == 'duration')
                            @php
                                $duration = new DateInterval($video->contentDetails->$k);
                                $duration_new = $duration->format('%H:%I:%S');
                            @endphp
                            <tr>
                                <td>{{$k}}</td>
                                <td>{{$duration_new}}</td>
                            </tr>
                        @else
                            <tr>
                                <td>{{$k}}</td>
                                <td>{{$video->contentDetails->$k}}</td>
                            </tr>
                        @endif
                    @endforeach

                    <tr>
                        <td colspan="2"><strong>statistics</strong></td>
                    </tr>
                    @foreach($video->statistics as $k => $v)
                        <tr>
                            <td>{{$k}}</td>
                            <td>{{$video->statistics->$k}}</td>
                        </tr>
                    @endforeach

                    {{-- Вывод картинок видео, может быть полезно в дальнейшем --}}
                    {{-- начало --}}
{{--                    <tr>--}}
{{--                        <td>default</td>--}}
{{--                        <td>--}}
{{--                            <img src="{{$snippet->thumbnails->default->url}}" alt="">--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>medium</td>--}}
{{--                        <td>--}}
{{--                            <img src="{{$snippet->thumbnails->medium->url}}" alt="">--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>high</td>--}}
{{--                        <td>--}}
{{--                            <img src="{{$snippet->thumbnails->high->url}}" alt="">--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                    {{--  конец --}}

                </table>

            </div>
        @else
            <h4>Не удалось воспроизвести видео, пожалуйста, попробуйте позже</h4>
        @endif
    </div>

@endsection