<?php

namespace App\Http\Controllers;

use App\Models\MGDebug;
use DateInterval;
use Illuminate\Http\Request;

class YouTubeController extends Controller
{
    protected string $youtube_api_key_1 = 'AIzaSyA8uSUgr6vMKaEHYXzGKjltL6OzhM8IuqM';
    protected string $youtube_api_key_2 = 'AIzaSyB1bK2ug49EZTgCJ4icWjt79e7ETmqul58';
    protected string $youytube_channelid_template = 'https://www.youtube.com/channel/';

    public function index(){
        return view('youtube.index');
    }

    /*
     * Передача шаблону с плееером $ytVideoId
     *
     */
    public function watch(Request $request)
    {
        $ytVideoId = "e90TvNVlxr4";
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

    //
    public function actionGetYtVideoByHash($id='')
    {
        if (!Authlib::appIsAuth()) {
            echo json_decode(['success' => 'no', 'message' => 'auth is required']); die('wow');
        }

        if (Yii::$app->request->isAjax){
            // <iframe width="560" height="315" src="https://www.youtube.com/embed/7rGxox4gAgE?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            $iframe = <<<IFRAME
<iframe width="560" height="315" src="https://www.youtube.com/embed/{$id}?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
IFRAME;
            $rs = ['success' => 'yes', 'message' => 'video is finded', 'iframe' => $iframe ];
            die(json_encode($rs));
        }
    }

    //
    public function actionMaxheight()
    {
        $ids[] = 'N584L3HdLfg';
        $api_key = Yii::$app->params['youtube_api_key_1'];

        $client = new Google_Client();
        $client->setDeveloperKey($api_key);
        $youtube = new Google_Service_YouTube($client);

        //$rs = $youtube->videos->listVideos('snippet, statistics, contentDetails', [
        //    'id' => $ids,
        //]);
        $rs = $youtube->search->listSearch('id,snippet', array(
            'q' => 'x79 huanan',
            'maxResults' => 3,
        ));

        $this->layout = '_main';
        return $this->render('testmaxheight',['rs' => $rs ]);
    }

    //
    public function actionSearch222()
    {
        $searchModel = new VideoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->layout = '_main';
        return $this->render('search222', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    //
    public function actionSearch()
    {
        $rs = false; $model = new VideoSearch2();
        if (Yii::$app->request->isPost){
            //echo Debug::d($searchModel,'searchModel');
            //echo Debug::d($_REQUEST,'request');
            $nkey = 'VideoSearch2';
            if (array_key_exists($nkey,$_REQUEST) && is_array($_REQUEST[$nkey]) && count($_REQUEST[$nkey])){
                //$a = Yii::$app->request->post(['Video']);
                $a = $_POST[$nkey];
                $searchModel = Video::find()
                    ->where(['i_user' => $_SESSION['user']['id'], 'active' => '1'])
                    ->with('categoryvideo');
                //
                $model->i_cat = 0;
                if (array_key_exists('i_cat',$a) && $a['i_cat'] !== '0' ){
                    $searchModel = $searchModel->andWhere(['like', 'i_cat',    $a['i_cat'] ]);
                    $model->i_cat = $a['i_cat'];
                }
                if (array_key_exists('title',$a)){
                    $model->title = $a['title'];
                    $searchModel = $searchModel->andWhere(['like', 'title',    $a['title'] ]);
                }
                if (array_key_exists('duration',$a)){
                    $model->duration = $a['duration'];
                    $searchModel = $searchModel->andWhere(['like', 'duration', $a['duration'] ]);
                }
                //echo Debug::d($searchModel,'$searchModel');
                //$searchModel = $searchModel->all();
                $searchModel = $searchModel->asArray()->all();//->count();
                $rs = $searchModel;
                //echo Debug::d($searchModel,'$searchModel',1,1);
            }
        }

        $this->layout = '_main';
        return $this->render('search', [
            'model' => $model, 'rs' => $rs
        ]);

    }

    //
    // Search in YOUTUBE API
    //
    public function actionYtSearch1(){

        if (!Authlib::appIsAuth()) { AuthLib::appGoAuth(); }
        // используется вариант с самим объектом youyube -> search -> listSearch

        $api_key = Yii::$app->params['youtube_api_key_1'];

        $client = new Google_Client();
        $client->setDeveloperKey($api_key);
        $youtube = new Google_Service_YouTube($client);

        //$rs = $youtube->videos->listVideos('snippet, statistics, contentDetails', [
        //    'id' => $ids,
        //]);

        $orderArray = [
            'relevance', 'viewCount', 'rating', 'title', 'date', 'videoCount',
        ];
        //
        $durationArray = [
            'any', 'long', 'medium', 'short',
        ];
        //
        $typeArray = [
            'video', 'channel', 'playlist',
        ];
        //
        $q['key'] = '';
        $q['caption'] = 'Query string';
        $q['value'] = '';
        //
        $safeSearchArray = [
            'moderate',
            'none',
            'strict',
        ];


        ///
        $maxResults['key'] = 0;
        $maxResults['caption'] = 'maxResults';
        $maxResults['value'] = 7;
        //
        $order['key'] = 0;
        $order['value'] = $orderArray[0];
        $order['caption'] = 'Order';
        //
        $duration['key'] = 0;
        $duration['value'] = $durationArray[0];
        $duration['caption'] = 'duration';
        //
        $type['key'] = 0;
        $type['value'] = $typeArray[0];
        $type['caption'] = 'type';
        //
        $order['key'] = 0;
        $order['value'] = $orderArray[0];
        $order['caption'] = 'Order';
        //
        $publishedBefore = date('Y-m-d\Th:i:s\Z');
        //echo $publishedBefore; echo "<br>";

        //$publishedAfter = '1970-01-01T00:00:00Z';
        $publishedAfter = date("c", strtotime("1970-03-10"));

        // moderate || none || strict
        $safeSearch['key'] = 2;
        $safeSearch['value'] = $safeSearchArray[$safeSearch['key']];
        //$safeSearch['value'] = 'strict';
        //echo $safeSearch['value']; die;
        $safeSearch['caption'] = 'safeSearch';

        //
        if(Yii::$app->request->isPost) {
            if (array_key_exists('yt-search-text', $_POST)){
                $q['value'] = $_POST['yt-search-text'];
            }
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
                if ( !($maxResults['value'] >= 0 && $maxResults['value'] <= 99) ){
                    $maxResults['value'] = 7;
                }
            }
            if (array_key_exists('publishedBefore', $_POST) && mb_strlen($_POST['publishedBefore']) >= 8 ){
                $publishedBefore = Yii::$app->formatter->asDatetime($_POST['publishedBefore'],DATE_RFC3339);
                $publishedBefore = date("c", strtotime($_POST['publishedBefore']));
                //$publishedBefore = Yii::$app->formatter->asDatetime($_POST['publishedBefore'],'Y-MM-dd\Th:i:s');
                //$publishedBefore .= 'Z';
                //echo $publishedBefore; echo "<br>";
                //echo $publishedAfter; echo "<br>";
                //die;
            }
            if (array_key_exists('publishedAfter', $_POST)){
                $publishedAfter = Yii::$app->formatter->asDatetime($_POST['publishedAfter'],DATE_RFC3339);
                $publishedAfter = date("c", strtotime($_POST['publishedAfter']));
                //$publishedAfter = Yii::$app->formatter->asDatetime($_POST['publishedAfter'],'Y-MM-dd\Th:i:s');
                //$publishedAfter .= 'Z';
                //echo $publishedBefore; echo "<br>";
                //echo $publishedAfter; echo "<br>";
                //die;
            }
            //
            if (array_key_exists('safeSearch',$_POST) && array_key_exists( $_POST['safeSearch'], $safeSearchArray ) ){
                $safeSearch['key'] = $_POST['safeSearch'];
                $safeSearch['value'] = $safeSearchArray[intval($safeSearch['key'])];
            }
        }

        // debug
        // try change date - after and before
//        $d1 = date("c", strtotime("1970-03-10"));
//        $d2 = date("c", strtotime("2015-03-10"));
//        $publishedAfter  = $d1;
//        $publishedBefore = $d2;

        $filters = [
            'q' => $q['value'],
            'safeSearch' => $safeSearch['value'],
            'type' => $type['value'],
            'order'=> $order['value'],
            'publishedBefore' => $publishedBefore,
            'publishedAfter' => $publishedAfter,
            'maxResults' => $maxResults['value'],
            'videoDuration' => $duration['value'],
            'maxResults' => $maxResults['value'],
        ];

        $publishedBefore = mb_substr($publishedBefore,0,10);
        $publishedAfter  = mb_substr($publishedAfter, 0,10);
        //
        $part = "snippet";
        $rs = $youtube->search->listSearch($part, $filters);
        //echo $publishedBefore; echo "<br>";
        //echo Debug::d($rs,'youtube result',1);

        // debug video by id
        //$testVideoId = 'https://www.youtube.com/watch?v=JZT8R1pkNW4';
        //$testVideoRs = self::actionYoutubeFindVideoById(self::actionYoutubeParseUrl($testVideoId));
        //echo Debug::d($testVideoRs,'$testVideoRs');
        $this->layout = '_main';
        return $this->render('ytsearch1',['rs' => $rs,
            'q' => $q,
            'part'=>$part,
            'orderArray' => $orderArray, 'order' => $order,
            'durationArray' => $durationArray, 'duration' => $duration,
            'typeArray' => $typeArray, 'type' => $type,
            'maxResults' => $maxResults,
            'publishedBefore' => $publishedBefore,
            'publishedAfter' => $publishedAfter,
            'safeSearch' => $safeSearch,
            'safeSearchArray' => $safeSearchArray,

        ]);
    }

    public function actionChannels()
    {
        // используется вариант с fileGetContents
        // channels

        $params = array(
            'part' => 'contentDetails',
            'mine' => true,
        );
        $url = 'https://www.googleapis.com/youtube/v3/channels?' . http_build_query($params);

        $params = array(
            'part' => 'contentDetails',
            'playlistId' => 'LL3PyIqYQ7lw7YKHRLqIvXlw',
        );
        $url = 'https://www.googleapis.com/youtube/v3/playlistItems?' . http_build_query($params);

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
        $json_result = fopen($url, 'r', false, $context);
        $json_decode = json_decode(stream_get_contents($json_result));
        //echo Debug::d(stream_get_meta_data($json_result),'stream_get_meta_data($stream)');
        echo Debug::d($json_decode,'stream_get_meta_data($stream)');

        //
//        $api_key = Yii::$app->params['youtube_api_key_1'];
//        $client = new Google_Client();
//        $client->setDeveloperKey($api_key);
//        $youtube = new Google_Service_YouTube($client);
//        $rs = $youtube->search->listSearch('id,snippet', array(
//            'q' => 'x79 huanan',
//            'maxResults' => 3,
//        ));

    }

}