@extends('layouts.event')

@section('content')

    @if($ytVideoId)
        <div class="row">
            <div class="col-md-6">
                <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/{{$ytVideoId}}"
                        frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                </iframe>
            </div>
        </div>
    @endif

    @if(!property_exists($jsonData, 'error'))
        <div>
            <h3>YouTube - show player with static video_id: {{$ytVideoId}}</h3>

            <div class="row">
                <div class="col-md-12">
                    <?php
                    $video = $jsonData->items[0];
                    $snippet = $video->snippet;
                    //echo \App\Models\MGDebug::d($video);
                    ?>
                    <table class="table table-bordered table-striped table-responsive youtubePlayer">
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
                            <td>{{\Illuminate\Support\Carbon::parse($snippet->publishedAt)->format('d.m.Y h:i:s') }}</td>
                        </tr>
                        <tr>
                            <td>channelId</td>
                            <td>
                                <a href="{{'https://www.youtube.com/channel/'.$snippet->channelId}}">
                                    {{$snippet->channelTitle}}
                                </a>
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
                                @php
                                    //dump($video->contentDetails);
                                @endphp
                                <tr>
                                    <td>{{$k}}</td>
                                    <td>
                                        @php
                                            //echo \App\Models\MGDebug::d($video->contentDetails->$k,'',2);
                                        @endphp
                                        @if(!is_object($video->contentDetails->$k))
                                            {{$video->contentDetails->$k}}
                                        @else
                                            there is object
                                        @endif
                                    </td>
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
            </div>
        </div>
    @else
        <h4>Не удалось получить подробности видео, пожалуйста, попробуйте позже</h4>
    @endif

@endsection