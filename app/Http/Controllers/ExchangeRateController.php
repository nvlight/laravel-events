<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ExchangeRateController extends Controller
{
    private $url;
    private $timeout;
    private $streamContextOptions;
    private $needJsonArrayKeys;
    private $fileName;

    public function __construct()
    {
        $this->fileName = "";
        $this->url = config('services.cbr.url_json', 'cbr-xml-daily.json_decoded');
        $this->timeout = config('services.cbr.timeout', 3);
        $this->streamContextOptions = [
            'ssl'   => ['verify_peer' => true,  'verify_peer_name' => true, ],
            'https' => ['timeout' => $this->timeout],
            'http'  => ['timeout' => $this->timeout],
        ];
        $this->needJsonArrayKeys = ['Valute', 'Date', 'PreviousDate', 'PreviousURL', 'Timestamp'];
        $this->fileName = config('services.cbr.path2save') . '/' . config('services.cbr.filename');
    }

    public function index()
    {
        $gcer = null;
        return view('exchange-rate.index', compact('gcer'));
    }

    public function getLastExchangeRateHtml()
    {
        $gcer = $this->getExchangeRate();
        if ( !$gcer['success']){
            $this->updateExchangeRate();
            $gcer = $this->getExchangeRate();
        }

        //*
        if ($gcer['success']){
            $diffs = $this->getExchangeRateDiffs($gcer);
            if ($this->isUpdateExchangeRateConditionPass($diffs)['success']){
                //dd($diffs);
                $this->updateExchangeRate();
                logger('isUpdateExchangeRateConditionPass --> updateExchangeRate');
                $gcer = $this->getExchangeRate();
            }
        }
        //*/

        //dd($gcer);

        $gcerResultHtmlRender = View::make('exchange-rate.get_last', compact('gcer') )->render();

        $gcerHtml = json_encode(['html' => $gcerResultHtmlRender]);

        return die($gcerHtml);
    }

    protected function isLocalExchangeRateExists(){
        if ( !(Storage::disk('local')->exists($this->fileName)) ){
            return ['success' => 0, 'message' => 'file is not exists'];
        }
        return ['success' => 1];
    }

    public function getExchangeRateFile(){
        return Storage::disk('local')->get($this->fileName);
    }

    protected function getExchangeRateJsonDecoded(){
        $json = json_decode($this->getExchangeRateFile(), true);
        if (!$json){
            return ['success' => 0, 'message' => 'json_decode is null'];
        }

        return ['success' => 1, 'json_decode' => $json];
    }

    protected function isLocalExchangeRateCheckPass($array, $keys){
        $success = 1; $lastErrorKey = -1;
        foreach($keys as $k => $v){
            if ( !array_key_exists($v, $array)){
                $success = 0;
                $lastErrorKey = $k;
            }
        }

        return ['success' => $success, 'last_error_key' => $lastErrorKey];
    }

    public function isUpdateExchangeRateConditionPass($diff){
        if ($diff['success']){
            if ( isset($diff['diff']['diffInDays']) && $diff['diff']['diffInDays'] >= 2){
                return ['success' => 1, 'condition is passed'];
            }
        }
        return ['success' => 0,  'message' => 'condition is NOT passed'];
    }

    public function getExchangeRateDiffs($currentJson){

        if ($currentJson['success']){
            $timeZone = env('TIMEZONE');
            //dump($currentJson['data']['Date']);

            // example for test
            //$customDateTime = "2021-01-20T11:30:00+03:00";
            //$erDateTime = Carbon\Carbon::parse($customDateTime)->timezone($timeZone);
            $erDateTime = Carbon::parse($currentJson['data']['Date'])->timezone($timeZone);
            $nowDateTime = Carbon::now($timeZone);
            //dump($nowDateTime);

            $rs['diffInDays'] =    $erDateTime->diffInDays($nowDateTime);
            $rs['diffInMinutes'] = $erDateTime->diffInMinutes($nowDateTime);
            $rs['diffInSeconds'] = $erDateTime->diffInSeconds($nowDateTime);

            //dump($rs);

            return ['success' => 1, 'diff' => $rs];
        }

        return ['success' => 0, 'result of saved getExchangeRate json file is empty or incorrect format'];
    }

    public function updateExchangeRate2(){
        $result = ['success' => 1];
        try {
            $newFile = file_get_contents($this->url, false, stream_context_create($this->streamContextOptions));
            $jsonDecode = json_decode($newFile);
            //dump($jsonDecode);

            if ( $jsonDecode){
                Storage::disk('local')->put($this->fileName, $newFile);
                $message = "jsonDecode is stored";
            }else{
                //Storage::disk('local')->delete($this->fileName);
                $message = 'updateExchangeRate is failed - json_decode is null';
            }

            $result['message'] = $message;
            logger($message);
        }catch (\Exception $e){
            $message = 'updateExchangeRate is failed!';
            $result['message'] = $message;
            $result['success'] = 0;
            logger($message);
        }

        return $result;
    }

    public function updateExchangeRate(){
        $result = ['success' => 1];
        try {
            $newFile = $this->file_get_contents_curl($this->url);
            $jsonDecode = json_decode($newFile);
            //dump($jsonDecode);

            if ( $jsonDecode){
                Storage::disk('local')->put($this->fileName, $newFile);
                $message = "jsonDecode is stored";
            }else{
                //Storage::disk('local')->delete($this->fileName);
                $message = 'updateExchangeRate is failed - json_decode is null';
            }

            $result['message'] = $message;
            logger($message);
        }catch (\Exception $e){
            $message = 'updateExchangeRate is failed!';
            $result['message'] = $message;
            $result['success'] = 0;
            logger($message);
        }

        return $result;
    }

    private function file_get_contents_curl( $url ) {

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

        $data = curl_exec( $ch );
        curl_close( $ch );

        return $data;

    }

    public function getExchangeRate()
    {
        $exists = $this->isLocalExchangeRateExists();
        if ( !$exists['success']){
            logger('getExchangeRate: ' . $exists['message']);
            return $exists;
        }

        $file = $this->getExchangeRateJsonDecoded();
        if ( !$file['success']){
            logger('getExchangeRate: ' . $file['message']);
            return $file;
        }

        $pass = $this->isLocalExchangeRateCheckPass($file['json_decode'] , $this->needJsonArrayKeys);
        if ( !$pass['success']) {
            logger('getExchangeRate: ' . $pass['message']);
            return $pass;
        }

        return ['success' => 1, 'data' => $file['json_decode'] ] ;
    }

}