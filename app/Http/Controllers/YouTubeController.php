<?php

namespace App\Http\Controllers;

use App\Models\MGDebug;
use Illuminate\Http\Request;

class YouTubeController extends Controller
{
    protected $youtube_api_key_1 = 'AIzaSyDSJ9CxBFXnNvbWBwQVHeM1plBUs9wcASA';
    protected $youtube_api_key_11 = 'AIzaSyA8uSUgr6vMKaEHYXzGKjltL6OzhM8IuqM';
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
     * Получение видео (fOpen)
     *
     * */
    public function ApiGetVideoByMethodFopen(string $video_id)
    {
        $video_id = 'wHObvCfiUyI';

        $url = 'https://www.googleapis.com/youtube/v3/videos';
        // part=snippet,contentDetails,statistics&fields=items(id,contentDetails,etag,snippet(publishedAt,title,description,thumbnails(medium),channelTitle,localized),statistics)";
        $data = array (
            'key' => $this->youtube_api_key_1,
            'part' => 'snippet,contentDetails,statistics',
            'fields' => 'items(id,contentDetails,etag,snippet(publishedAt,title,description,thumbnails(medium),channelTitle,localized),statistics)',
            'id' => $video_id
        );

        $scu = $url . '?' . http_build_query($data);
        $opts = array('http' =>
            array(
                'method' => 'GET',
                'max_redirects' => '0',
                'ignore_errors' => '1',
            )
        , 'ssl' => array(
                'verify_peer' => true,
                'cafile' => '/SRV/php721/extras/ssl/' . "cacert.pem",
                'ciphers' => 'HIGH:TLSv1.2:TLSv1.1:TLSv1.0:!SSLv3:!SSLv2',
                'CN_match' => 'www.googleapis.com',
                'disable_compression' => true,
            )
        );

        $context = stream_context_create($opts);
        $stream = fopen($scu, 'r', false, $context);

        // check ?
        $response = json_decode(stream_get_contents($stream));

        fclose($stream);

        return $response;
    }

    /*
     * Получение видео (fileGetContents)
     *
     * */
    public function ApiGetVideoByMethodFileGetContents(string $video_id)
    {
        $params = array(
            'id' => $video_id,
            'key' => $this->youtube_api_key_1,
            'part' => 'snippet,contentDetails,statistics',
            'fields' => 'items(id,contentDetails,etag,snippet(publishedAt,title,description,thumbnails(default,medium,high),channelTitle,localized),statistics)'
        );
        $url = 'https://www.googleapis.com/youtube/v3/videos?' . http_build_query($params);

        $opts = array('http' =>
            array(
                'method' => 'GET',
                'max_redirects' => '0',
                'ignore_errors' => '1',
            )
        , 'ssl' => array(
                'verify_peer' => true,
                'cafile' => '/SRV/php721/extras/ssl/' . "cacert.pem",
                'ciphers' => 'HIGH:TLSv1.2:TLSv1.1:TLSv1.0:!SSLv3:!SSLv2',
                //'CN_match' => $cn_match,
                'disable_compression' => true,
            )
        );

        $context = stream_context_create($opts);

        // check ?
        $json_result = file_get_contents ($url,false ,$context);

        return $json_result;
    }

    /*
     * Поиск видое по ключам
     *
     * */
    public function search(Request $request)
    {
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
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $q['value'] = $request->post('yt-search-text') ?? '';

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

            //dump($request->post('safeSearch'));
            //dump($safeSearchArray);
            if (array_key_exists($request->post('safeSearch'), $safeSearchArray)){
                $safeSearch['key'] = $request->post('safeSearch');
                $safeSearch['value'] = $safeSearchArray[$request->post('safeSearch')];
            }

            // pageToken
            if ($request->post('nextPageToken')){
                $nextPageToken = $request->post('nextPageToken');
            }
            if ($request->post('prevPageToken')){
                $prevPageToken = $request->post('prevPageToken');
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
            $ytError = $th->getMessage();
        }
        //dump($rs);
        //echo MGDebug::d($rs);

        return view('youtube.search',[
            'rs' => $rs,
            'q' => $q,
            'part'=> $part,
            'orderArray' => $orderArray, 'order' => $order,
            'durationArray' => $durationArray, 'duration' => $duration,
            'typeArray' => $typeArray, 'type' => $type,
            'maxResults' => $maxResults,
            'publishedBefore' => $publishedBefore,
            'publishedAfter' => $publishedAfter,
            'safeSearch' => $safeSearch,
            'safeSearchArray' => $safeSearchArray,
            'ytError' => $ytError,
        ]);
    }

}