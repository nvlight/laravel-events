@extends('layouts.event')

@section('content')

    <h3>YouTube - search</h3>

    <div class="youtube_search">

        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <form action="{{URL::to('youtube_search')}}" method="POST">
                    @csrf

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
        </div>


        @if(
            is_object($rs) &&
            is_array($rs['modelData']) &&
            is_array($rs['modelData']['pageInfo']) &&
            array_key_exists('totalResults',$rs['modelData']['pageInfo'] ) &&
            $rs['modelData']['pageInfo']['totalResults'] > 0 )

        <?php
            $items = $rs['modelData']['items'];
            //echo \App\Models\MGDebug::d($items);
            //dump($items);
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-responsive">
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
                                <a href="{{URL::to('youtube_watch/'.$v['id']['videoId'])}}">
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
                                {{$v['snippet']['publishedAt']}}
                            </td>
                            <td>
                                <a href="{{URL::to('youtube_watch/'.$v['id']['videoId'])}}">Watch!</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        @endif

    </div>

    <!-- Модаль -->
    <div class="modal fade" id="watchLideModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Просмотр видео</h4>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

@endsection