@extends('layouts.event')

@section('content')

    <div class="container">

        <h2 class="title is-1 has-text-centered">HD video</h2>
        <div class="api_response">
            @if($ApiResponse)

                @if($ApiResponse['success'])

                    <div class="api_response_data">
                        <?php //dump($ApiResponse['data']); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="MG_snippet-preview">
                                <form action="" class="search">

                                    <div class="field mt-3">
                                        <label class="label" for="title">Title</label>
                                        <div class="">
                                            <input class="form-control" type="text" id="title" name="title" placeholder="type title" value="{{request()->get('title')}}">
                                        </div>
                                    </div>

                                    <div class="field mt-3">
                                        <label class="label" for="kinopoisk_id">Kinopoisk</label>
                                        <div class="">
                                            <input class="form-control" type="text" id="kinopoisk_id" name="kinopoisk_id" placeholder="type kinopoisk id" value="{{request()->get('kinopoisk_id')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="mt-2 mb-1">
                                            <button class="btn btn-success" type="submit">Search it!</button>
                                        </div>
                                        <div class="mt-2 mb-1">
                                            <button class="btn btn-warning" type="reset">Cancel</button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                            <nav class="pagination" role="navigation" aria-label="pagination">
                                <ul class="pagination-list">
                                    <li>
                                        <a class="pagination-link is-current"
                                           @if ($currentPage <=1)
                                           disabled
                                           @endif
                                           href="{{$prevPageUrl}}">Previous</a>
                                    </li>
                                    <li>
                                        <a class="pagination-link is-current" >{{$currentPage}}</a>
                                    </li>
                                    <li>
                                        <a class="pagination-link is-current" href="{{$nextPageUrl}}">Next page</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-9">

                            <style>
                                .MG_showButton{
                                    cursor: pointer;
                                    font-weight: bold;

                                }
                            </style>

                            <div class="column">
                                <table class="table table-responsive table-striped table-bordered">
                                    <tr>
                                        {{--                        <th>id</th>--}}
                                        <th>title</th>
                                        {{--                        <th>kp_id</th>--}}
                                        {{--                        <th>imdb_id</th>--}}
                                        {{--                        <th>world_art_id</th>--}}
                                        {{--                        <th>type</th>--}}
                                        {{--                        <th>add</th>--}}
                                        {{--                        <th>orig_title</th>--}}
                                        <th>year</th>
                                        {{--                        <th>translations</th>--}}
                                        {{--                        <th>quality</th>--}}
                                        {{--                        <th>translation</th>--}}
                                        {{--                        <th>update</th>--}}
                                        <th>iframe_src</th>
                                    </tr>
                                    @foreach($ApiResponse['data']['data'] as $k => $v)
                                        <tr data-trId="{{$v['id']}}">
                                            {{--                            <td>{{$v['id']}}</td>--}}
                                            <td>{{$v['title']}}</td>
                                            {{--                            <td>{{$v['kp_id']}}</td>--}}
                                            {{--                            <td>{{$v['imdb_id']}}</td>--}}
                                            {{--                            <td>{{$v['world_art_id']}}</td>--}}
                                            {{--                            <td>{{$v['type']}}</td>--}}
                                            {{--                            <td>{{$v['add']}}</td>--}}
                                            {{--                            <td>{{$v['orig_title']}}</td>--}}
                                            <td>{{$v['year']}}</td>
                                            {{--                            <td>{{$v['update']}}</td>--}}
                                            <td>
                                        <span
                                                class="MG_showButton"
                                                data-show-button="{{$v['id']}}"
                                                data-iframe-src="{{$v['iframe_src']}}"
                                        >
                                            Смотреть!</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>

                            <div class="column">
                                <iframe id="playerMain" src="" width="640" height="480" frameborder="0" allowfullscreen></iframe>
                            </div>

                        </div>
                    </div>

                @else
                    <p>Api response is null!</p>
                @endif

            @else
                <p>Api response param count is 0</p>
            @endif
        </div>

        <script>
            let mbButtons = document.querySelectorAll('.MG_showButton');
            for (let i = 0; i < mbButtons.length; i++) {
                mbButtons[i].addEventListener('click', function() {
                    let iframeSrc = this.dataset.iframeSrc;
                    console.log(this.dataset.showButton + iframeSrc);
                    let playerMain = document.querySelector('#playerMain');
                    playerMain.setAttribute("src", iframeSrc);
                });
            }
        </script>

    </div>


@endsection