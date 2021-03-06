@extends('layouts.event')

@section('content')

    <h3>YouTube - search</h3>

    <div class="youtube/search">

        @if($rs)
            <div class="row">
                <div class="col-md-2">
                    <form action="{{URL::to('youtube/search')}}" method="GET">
                        <div class="form-group">
                            <label for="videoQueryString">{{$q['caption']}}</label>
                            <input type="text" name="yt-search-text" class="form-control"
                                   id="videoQueryString" placeholder="Enter search string"
                                   value="{{$q['value']}}">
                        </div>
                        <div class="form-group">
                            <label for="maxResults">{{$maxResults['caption']}}</label>
                            <input type="text" name="maxResults" class="form-control"
                                   id="maxResults" placeholder="Enter results count from [0-50]"
                                   value="{{$maxResults['value']}}">
                        </div>

                        <div class="form-group">
                            <label for="videoOrder">{{$order['caption']}}</label>
                            <select class="form-control" id="videoOrder" name="order">
                                @foreach($orderArray as $k => $v)
                                    <option value="{{$k}}" @if($k === $order['key']) selected @endif>
                                        {{$v}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="videoDuration">{{$duration['caption']}}</label>
                            <select class="form-control" id="videoDuration" name="duration">
                                @foreach($durationArray as $k => $v)
                                    <option value="{{$k}}" @if($k === $duration['key']) selected @endif>
                                        {{$v}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            //echo \App\Models\MGDebug::d($safeSearch['key'],'$safeSearch[key]',1);
                            //echo \App\Models\MGDebug::d($safeSearchArray,'$safeSearchArray',1);
                            ?>
                            <label for="safeSearch">{{$safeSearch['caption']}}</label>
                            <select class="form-control" id="safeSearch" name="safeSearch">
                                @foreach($safeSearchArray as $k => $v)
                                    <option value="{{$k}}" @if($k == $safeSearch['key']) selected @endif>
                                        {{$v}} @if($k == $safeSearch['key']) (SELECTED) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="publishedAfter">publishedAfter</label>
                            <input data-provide="datepicker" name="publishedAfter" id="publishedAfter"
                                   class="form-control {{ $errors->has('mg-yt-date-publishedAfter') ? 'border-danger' : '' }} publishedAfter"
                                   placeholder="<?=Date('Y.m.d')?>" value="{{$publishedAfter}}">
                            <script>
                                $('.publishedAfter').datepicker({
                                    'format' : 'yyyy-mm-dd',
                                    'language' : 'ru',
                                    'zIndexOffset' : 1000,
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="publishedBefore">publishedBefore</label>
                            <input data-provide="datepicker" name="publishedBefore" id="publishedBefore"
                                   class="form-control {{ $errors->has('mg-yt-date-publishedBefore') ? 'border-danger' : '' }} publishedBefore"
                                   placeholder="<?=Date('Y.m.d')?>" value="{{$publishedBefore}}">
                            <script>
                                $('.publishedBefore').datepicker({
                                    'format' : 'yyyy-mm-dd',
                                    'language' : 'ru',
                                    'zIndexOffset' : 1000,
                                });
                            </script>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Search it!</button>
                        </div>

                    </form>
                </div>

                @if( is_object($rs) && is_array($rs['modelData']) && is_array($rs['modelData']['pageInfo']) && array_key_exists('totalResults',$rs['modelData']['pageInfo'] ) && $rs['modelData']['pageInfo']['totalResults'] > 0 )
                    @php
                        $items = $rs['modelData']['items'];
                        //echo \App\Models\MGDebug::d($items);
                        //dump($items);
                    @endphp

                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive youtubePlayer">
                                <tr>
                                    <th>Thumbnail</th>
                                    <th>title</th>
                                    <th>description</th>
                                    <th>channelTitle</th>
                                    <th>PublishedAt</th>
                                    <th>link</th>
                                </tr>
                                @foreach($items as $k => $v)
                                    <tr>
                                        <td>
                                            <a href="{{URL::to('youtube/watch/'.$v['id']['videoId'])}}">
                                                <img src="{{$v['snippet']['thumbnails']['default']['url']}}" alt="">
                                            </a>
                                        </td>
                                        <td>{{$v['snippet']['title']}}</td>
                                        <td>{{$v['snippet']['description']}}</td>
                                        <td>
                                            <a href="{{'https://www.youtube.com/channel/'.$v['snippet']['channelId']}}">
                                                {{$v['snippet']['channelTitle']}}
                                            </a>
                                        </td>
                                        <td>
                                            {{\Illuminate\Support\Carbon::parse($v['snippet']['publishedAt'])->format('d.m.Y h:i:s') }}
                                        </td>
                                        <td>
                                            <a href="{{URL::to('youtube/watch/'.$v['id']['videoId'])}}">Watch!</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="mb-3">
                            <form class="d-inline-block" action="{{URL::to('youtube/search')}}" method="GET">
                                <div style="display: none">
                                    <input type="text" name="yt-search-text" class="form-control"
                                           id="videoQueryString" placeholder="Enter search string"
                                           value="{{$q['value']}}">
                                    <input type="text" name="maxResults" class="form-control"
                                           id="maxResults" placeholder="Enter results count from [0-50]"
                                           value="{{$maxResults['value']}}">
                                    <select class="form-control" id="videoOrder" name="order">
                                        @foreach($orderArray as $k => $v)
                                            <option value="{{$k}}" @if($k === $order['key']) selected @endif>
                                                {{$v}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select class="form-control" id="videoDuration" name="duration">
                                        @foreach($durationArray as $k => $v)
                                            <option value="{{$k}}" @if($k === $duration['key']) selected @endif>
                                                {{$v}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select class="form-control" id="safeSearch" name="safeSearch">
                                        @foreach($safeSearchArray as $k => $v)
                                            <option value="{{$k}}" @if($k == $safeSearch['key']) selected @endif>
                                                {{$v}} @if($k == $safeSearch['key']) (SELECTED) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <input data-provide="datepicker" name="publishedAfter" id="publishedAfter"
                                           class="form-control {{ $errors->has('mg-yt-date-publishedAfter') ? 'border-danger' : '' }} publishedAfter"
                                           placeholder="<?=Date('Y.m.d')?>" value="{{$publishedAfter}}">
                                    <input type="text" name="nextPageToken" value="{{$rs->prevPageToken}}">

                                    <script>
                                        $('.publishedAfter').datepicker({
                                            'format' : 'yyyy-mm-dd',
                                            'language' : 'ru',
                                            'zIndexOffset' : 1000,
                                        });
                                    </script>
                                    <input data-provide="datepicker" name="publishedBefore" id="publishedBefore"
                                           class="form-control {{ $errors->has('mg-yt-date-publishedBefore') ? 'border-danger' : '' }} publishedBefore"
                                           placeholder="<?=Date('Y.m.d')?>" value="{{$publishedBefore}}">
                                    <script>
                                        $('.publishedBefore').datepicker({
                                            'format' : 'yyyy-mm-dd',
                                            'language' : 'ru',
                                            'zIndexOffset' : 1000,
                                        });
                                    </script>
                                </div>
                                <button type="submit" class="btn btn-success">Prev page</button>
                            </form>
                            <form class="d-inline-block" action="{{URL::to('youtube/search')}}" method="GET">
                                <div style="display: none">
                                    <input type="text" name="yt-search-text" class="form-control"
                                           id="videoQueryString" placeholder="Enter search string"
                                           value="{{$q['value']}}">
                                    <input type="text" name="maxResults" class="form-control"
                                           id="maxResults" placeholder="Enter results count from [0-50]"
                                           value="{{$maxResults['value']}}">
                                    <select class="form-control" id="videoOrder" name="order">
                                        @foreach($orderArray as $k => $v)
                                            <option value="{{$k}}" @if($k === $order['key']) selected @endif>
                                                {{$v}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select class="form-control" id="videoDuration" name="duration">
                                        @foreach($durationArray as $k => $v)
                                            <option value="{{$k}}" @if($k === $duration['key']) selected @endif>
                                                {{$v}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select class="form-control" id="safeSearch" name="safeSearch">
                                        @foreach($safeSearchArray as $k => $v)
                                            <option value="{{$k}}" @if($k == $safeSearch['key']) selected @endif>
                                                {{$v}} @if($k == $safeSearch['key']) (SELECTED) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <input data-provide="datepicker" name="publishedAfter" id="publishedAfter"
                                           class="form-control {{ $errors->has('mg-yt-date-publishedAfter') ? 'border-danger' : '' }} publishedAfter"
                                           placeholder="<?=Date('Y.m.d')?>" value="{{$publishedAfter}}">
                                    <input type="text" name="nextPageToken" value="{{$rs->nextPageToken}}">

                                    <script>
                                        $('.publishedAfter').datepicker({
                                            'format' : 'yyyy-mm-dd',
                                            'language' : 'ru',
                                            'zIndexOffset' : 1000,
                                        });
                                    </script>
                                    <input data-provide="datepicker" name="publishedBefore" id="publishedBefore"
                                           class="form-control {{ $errors->has('mg-yt-date-publishedBefore') ? 'border-danger' : '' }} publishedBefore"
                                           placeholder="<?=Date('Y.m.d')?>" value="{{$publishedBefore}}">
                                    <script>
                                        $('.publishedBefore').datepicker({
                                            'format' : 'yyyy-mm-dd',
                                            'language' : 'ru',
                                            'zIndexOffset' : 1000,
                                        });
                                    </script>
                                </div>
                                <button type="submit" class="btn btn-success">Next page</button>
                            </form>
                        </div>
                    </div>

                @endif
            </div>

        @else
            <h5>Получили ошибки при обращении к серверу, попробуйте позднее</h5>
            <p>
                @php
                    dump($ytError);
                @endphp
            </p>
        @endif
    </div>

@endsection