<?php

namespace App\Http\Controllers;

use App\Models\MGDebug;
use Illuminate\Http\Request;

class YouTubeController extends Controller
{
    protected $youtube_api_key_1 = 'AIzaSyDhSNMOaEkPSxWpTKw6K0B5AHRrTFxYID0'; // api key 1
    #protected $youtube_api_key_1 = 'AIzaSyBvRC-HZsd7slDS-KpgmIC7obvYh3jO2aE'; // api key 2
    protected $youytube_channelid_template = 'https://www.youtube.com/channel/';

    public function index(){
        return view('youtube.index');
    }

    /*
     * Передача шаблону с плееером $ytVideoId
     *
     */
    public function watch(string $ytVideoId)
    {
        $jsonData = $this->ApiGetVideoByMethodCurl($ytVideoId);

        return view('youtube.show_player', compact('jsonData', 'ytVideoId'));
    }

    public function watch_redirect(Request $request)
    {
        //dump($request->get('video_id'));

        return redirect( route('youtube.watch', [$request->get('video_id')]) );
    }

    public function search_redirect(Request $request)
    {
        return redirect( route('youtube.search', $request->all() ) )->with('q', $request->get('q'));
    }

    /*
     * Получение видео (Curl)
     *
     * */
    public function ApiGetVideoByMethodCurl(string $ytVideoId)
    {
        // all available API keys or ...
        //$url = "https://www.googleapis.com/youtube/v3/videos?id=$video_id&key=$api_key&part=snippet,contentDetails,statistics&fields=items(id,contentDetails,etag,snippet(publishedAt,title,description,thumbnails(medium),channelId,channelTitle,localized),statistics)";

        $params = array(
            'id' => $ytVideoId,
            'key' => $this->youtube_api_key_1,
            'part' => 'snippet,contentDetails,statistics',
            'fields' => 'items(id,contentDetails,etag,snippet(publishedAt,title,description,thumbnails(default,medium,high),channelTitle,channelId,localized),statistics)'
        );
        $url = 'https://www.googleapis.com/youtube/v3/videos?' . http_build_query($params);

        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        // ? chech for errors ?!
        $jsonData = json_decode(curl_exec($curlSession));

        curl_close($curlSession);

        //echo MGDebug::d($jsonData);
        //dump($jsonData);

        return $jsonData;
    }

    /*
     * Поиск видео по ключам
     *
     * */
    public function search(Request $request)
    {
        //dump(session()->get('q'));

        $api_key = $this->youtube_api_key_1;

        $client = new \Google_Client();
        $client->setDeveloperKey($api_key);
        $youtube = new \Google_Service_YouTube($client);

        $orderArray = [
            'relevance', 'viewCount', 'rating', 'title', 'date', 'videoCount',
        ];

        $durationArray = [
            'any', 'long', 'medium', 'short',
        ];

        $typeArray = [
            'video', 'channel', 'playlist',
        ];

        $q['key'] = '';
        $q['caption'] = 'Query string';
        $q['value'] = '';

        $safeSearchArray = [
            'moderate',
            'none',
            'strict',
        ];

        $maxResults['max_right_number'] = 50;
        $maxResults['key'] = 0;
        $maxResults['caption'] = 'maxResults';
        $maxResults['value'] = 7;

        $order['key'] = 0;
        $order['value'] = $orderArray[0];
        $order['caption'] = 'Order';

        $duration['key'] = 0;
        $duration['value'] = $durationArray[0];
        $duration['caption'] = 'duration';

        $type['key'] = 0;
        $type['value'] = $typeArray[0];
        $type['caption'] = 'type';

        $order['key'] = 0;
        $order['value'] = $orderArray[0];
        $order['caption'] = 'Order';

        $publishedBefore = date('Y-m-d\Th:i:s\Z');
        $publishedAfter = date("c", strtotime("1970-03-10"));

        // moderate || none || strict
        $safeSearch['key'] = 2;
        $safeSearch['value'] = 'strict';
        $safeSearch['caption'] = 'safeSearch';

        $nextPageToken = "";
        $prevPageToken = "";

        //dd($request->all());
        if($_SERVER['REQUEST_METHOD'] === 'GET') {

            if (session('q')){
                $q['value'] = session()->get('q');
            }else{
                $q['value'] = $request->get('yt-search-text') ?? '';
            }

            //if (array_key_exists('yt-search-text', $_POST)){
            //    $q['value'] = $_POST['yt-search-text'];
            //}
            if (array_key_exists('order', $_POST)){
                foreach($orderArray as $k => $v){
                    if ( ($k) === intval($_POST['order'])) {
                        $order['key'] = $k;
                        $order['value'] = $v;
                    }
                }
            }
            if (array_key_exists('order', $_POST)){
                foreach($durationArray as $k => $v){
                    if ( ($k) === intval($_POST['duration'])) {
                        $duration['key'] = $k;
                        $duration['value'] = $v;
                    }
                }
            }
            if (array_key_exists('type', $_POST)){
                foreach($typeArray as $k => $v){
                    if ( ($k) === intval($_POST['type'])) {
                        $type['key'] = $k;
                        $type['value'] = $v;
                    }
                }
            }
            if (array_key_exists('maxResults', $_POST)){
                $maxResults['value'] = intval($_POST['maxResults']);
                if ( !($maxResults['value'] >= 0 && $maxResults['value'] <= $maxResults['max_right_number']) ){
                    $maxResults['value'] = $maxResults['max_right_number'];
                }
            }
            if (array_key_exists('publishedBefore', $_POST) && mb_strlen($_POST['publishedBefore']) >= 8 ){
                //$publishedBefore = Yii::$app->formatter->asDatetime($_POST['publishedBefore'],DATE_RFC3339);

                $publishedBefore = date("c", strtotime($_POST['publishedBefore']));
                //$publishedBefore = Yii::$app->formatter->asDatetime($_POST['publishedBefore'],'Y-MM-dd\Th:i:s');
                //$publishedBefore .= 'Z';
                //echo $publishedBefore; echo "<br>";
                //echo $publishedAfter; echo "<br>";
                //die;
            }
            if (array_key_exists('publishedAfter', $_POST)){
                //$publishedAfter = Yii::$app->formatter->asDatetime($_POST['publishedAfter'],DATE_RFC3339);

                $publishedAfter = date("c", strtotime($_POST['publishedAfter']));
                //$publishedAfter = Yii::$app->formatter->asDatetime($_POST['publishedAfter'],'Y-MM-dd\Th:i:s');
                //$publishedAfter .= 'Z';
                //echo $publishedBefore; echo "<br>";
                //echo $publishedAfter; echo "<br>";
                //die;
            }

            //dump($request->get('safeSearch'));
            //dump($safeSearchArray);
            if (array_key_exists($request->get('safeSearch'), $safeSearchArray)){
                $safeSearch['key'] = $request->get('safeSearch');
                $safeSearch['value'] = $safeSearchArray[$request->get('safeSearch')];
            }

            // pageToken
            if ($request->get('nextPageToken')){
                $nextPageToken = $request->get('nextPageToken');
            }
            if ($request->get('prevPageToken')){
                $prevPageToken = $request->get('prevPageToken');
            }
        }

        $filters = [
            'q' => $q['value'],
            'safeSearch' => $safeSearch['value'],
            'type' => $type['value'],
            'order'=> $order['value'],
            'publishedBefore' => $publishedBefore,
            'publishedAfter' => $publishedAfter,
            'maxResults' => $maxResults['value'],
            'videoDuration' => $duration['value'],
        ];
        if ($nextPageToken){
            $filters['pageToken'] = $nextPageToken;
        }
        if ($prevPageToken){
            $filters['pageToken'] = $prevPageToken;
        }

        //dump($filters);
        //echo MGDebug::d($filters);

        $publishedBefore = mb_substr($publishedBefore,0,10);
        $publishedAfter  = mb_substr($publishedAfter, 0,10);

        $part = "snippet";
        $rs = null; $ytError = null;
        try{
            $rs = $youtube->search->listSearch($part, $filters);
        }catch (\Throwable $th){
            // ok...
            $ytError = $th;
        }
        //dump($rs);
        //echo MGDebug::d($rs);

        return view('youtube.search',[
            'rs' => $rs,
            'q' => $q,
            'part'=> $part,
            'orderArray' => $orderArray,
            'order' => $order,
            'durationArray' => $durationArray,
            'duration' => $duration,
            'typeArray' => $typeArray,
            'type' => $type,
            'maxResults' => $maxResults,
            'publishedBefore' => $publishedBefore,
            'publishedAfter' => $publishedAfter,
            'safeSearch' => $safeSearch,
            'safeSearchArray' => $safeSearchArray,
            'ytError' => $ytError,
        ]);
    }

}