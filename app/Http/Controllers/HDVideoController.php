<?php

namespace App\Http\Controllers;

use App\Models\VideoCdnApi;
use Illuminate\Http\Request;

class HDVideoController extends Controller
{
    public function index()
    {
        $apiToken = env('VIDEOCDN_API_TOKEN');

        //dump($_SERVER);

        // form param - page
        $page = 1;
        if (isset($_GET['page']) && preg_match("#^[1-9]\d{0,9}$#", $_GET['page'])){
            $page = intval($_GET['page']);
        }
        $nextPage = $page + 1;
        $prevPage = $page - 1;
        if ($prevPage <= 0){
            $prevPage = 1;
        }

        //dd($_SERVER);
        // set next && prev URL for pagination
        $MG_SERVER = "http://" .  $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        // "QUERY_STRING" => "title=type+title&kinopoisk_id=type+kinopoisk+id&page=2"
        $MG_GET = $_GET;

        $MG_GET['page'] = $nextPage;
        $queryString = http_build_query($MG_GET);
        $nextPageUrl = $MG_SERVER . '?' . $queryString;

        $MG_GET['page'] = $prevPage;
        $queryString = http_build_query($MG_GET);
        $prevPageUrl = $MG_SERVER . '?' . $queryString;

        // form param - title
        $title = "";
        if (isset($_GET['title']) && mb_strlen($_GET['title']) > 2){
            $title = $_GET['title'];
        }

        $params = [];
        $params['api_token'] = $apiToken;
        //$params['kinopoisk_id'] = 472386;
        if ($page){
            $params['page'] = $page;
        }
        if ($title){
            $params['title'] = $title;
        }

        $ApiResponse = "";
        if (count($params)){
            $httBuildQuery = http_build_query($params);

            $url =  VideoCdnApi::$apiPrefix . 'short';
            $url .= "?" . $httBuildQuery;
            //dump($url);

            $ApiResponse = VideoCdnApi::getApiResponseShort($url);
            $currentPage = $ApiResponse['data']['current_page'];
        }
        //dump($apiToken);
        //dump($ApiResponse); die;

        //return view('newhome.index',compact('ApiResponse', 'nextPageUrl', 'prevPageUrl', 'currentPage'));
        return view('hdvideo.index', compact('ApiResponse', 'nextPageUrl', 'prevPageUrl', 'currentPage'));
    }

    public function watch(Request $request)
    {
        $validate = ['success' => 1];
        try{
            $validatedData = $request->validate([
                'idWatch' => ['required', 'int', 'min:1','max:999999'],
            ]);
        }catch (\Throwable $t){

            $validate = ['success' => 0, 'error' => $t];
        }
        //dump($validate);

        $idWatch = intval($request->idWatch);
        //dump($idWatch);

        ###################################
        // copy from index - start
        $apiToken = env('VIDEOCDN_API_TOKEN');

        //dump($_SERVER);

        // form param - page
        $page = 1;
        if (isset($_GET['page']) && preg_match("#^[1-9]\d{0,9}$#", $_GET['page'])){
            $page = intval($_GET['page']);
        }
        $nextPage = $page + 1;
        $prevPage = $page - 1;
        if ($prevPage <= 0){
            $prevPage = 1;
        }

        //dd($_SERVER);
        // set next && prev URL for pagination
        $MG_SERVER = "http://" .  $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        // "QUERY_STRING" => "title=type+title&kinopoisk_id=type+kinopoisk+id&page=2"
        $MG_GET = $_GET;

        $MG_GET['page'] = $nextPage;
        $queryString = http_build_query($MG_GET);
        $nextPageUrl = $MG_SERVER . '?' . $queryString;

        $MG_GET['page'] = $prevPage;
        $queryString = http_build_query($MG_GET);
        $prevPageUrl = $MG_SERVER . '?' . $queryString;

        // form param - title
        $title = "";
        if (isset($_GET['title']) && mb_strlen($_GET['title']) > 2){
            $title = $_GET['title'];
        }

        $params = [];
        $params['api_token'] = $apiToken;
        //$params['kinopoisk_id'] = 472386;
        if ($page){
            $params['page'] = $page;
        }
        if ($title){
            $params['title'] = $title;
        }


        $ApiResponse = "";
        if (count($params)){
            $httBuildQuery = http_build_query($params);

            $url =  VideoCdnApi::$apiPrefix . 'short';
            $url .= "?" . $httBuildQuery;
            dump($url);

            $ApiResponse = VideoCdnApi::getApiResponseShort($url);
            $currentPage = $ApiResponse['data']['current_page'];
        }
        // copy from index - end
        #######################################

        //$idWatch = intval($request->input('idWatch'));
        //dump(($request->all()));
        return view('hdvideo.index', compact('idWatch','ApiResponse', 'nextPageUrl', 'prevPageUrl', 'currentPage'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
