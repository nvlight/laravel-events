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

    //
    public function getLastExchangeRateHtml()
    {
        $gcer = $this->getExchangeRate();
        //dd($gcer);

        $gcerResultHtmlRender = View::make('exchange-rate.get_last', compact('gcer') )->render();

        $gcerHtml = json_encode(['html' => $gcerResultHtmlRender]);

        return die($gcerHtml);
    }

    protected function isLocalExchangeRateExists(){
        if ( !(Storage::disk('local')->exists($this->fileName)) ){
            return ['success' => 0, 'message', 'file is not exists'];
        }
        return ['success' => 1];
    }

    public function getExchangeRateFile(){
        return Storage::disk('local')->get($this->fileName);
    }

    protected function getExchangeRateJsonDecoded(){
        $json = json_decode($this->getExchangeRateFile(), true);
        if (!$json){
            return ['success' => 0, 'message', 'json_decode is null'];
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

    public function test(){
        return $this->getExchangeRate();
    }

    public function updateExchangeRate(){
        $result = ['success' => 1];
        try {
            $newFile = file_get_contents($this->url, false, stream_context_create($this->streamContextOptions));
            $jsonDecode = json_decode($newFile);
            dump($jsonDecode);

            if ( $jsonDecode){
                Storage::disk('local')->put($this->fileName, $newFile);
            }else{
                Storage::disk('local')->delete($this->fileName);
            }

            $message = 'updateExchangeRate is done!';
            $result['message'] = $message;
            logger($message);
        }catch (\Exception $e){
            $message = 'updateExchangeRate is failed!';
            $result['message'] = $message;
            logger($message);
        }

        return $result;
    }

    private function updateExchangeRate__test(){
        $newFile = file_get_contents($this->url, false, stream_context_create($this->streamContextOptions));
        $jsonDecode = json_decode($newFile);
        dump($jsonDecode);

        if ( $jsonDecode){
            Storage::disk('local')->put($this->fileName, $newFile);
        }else{
            Storage::disk('local')->delete($this->fileName);
        }
    }

    public function getExchangeRate()
    {
        $exists = $this->isLocalExchangeRateExists();
        if ($exists['success']){
            $file = $this->getExchangeRateJsonDecoded();
            if ($file['success']){
                $pass = $this->isLocalExchangeRateCheckPass($file['json_decode'] , $this->needJsonArrayKeys);
                if ($pass['success']){

                    return ['success' => 1, 'data' => $file['json_decode'] ] ;
                }
                return $pass;
            }
            return $file;
        }
        return $exists;
    }

    public function testDateDiffs(){

        $d1 = "2021-01-23T11:30:00+03:00";
        $d2 = "2021-01-22T11:30:00+05:00";

        $dp1 = Carbon::parse($d1);
        $dp2 = Carbon::parse($d2)->format('d.m.Y h:m:s');
        $dp3 = Carbon::now('Europe/Moscow');

        $rs['diffInDays'] = $dp1->diffInDays($dp2);
        $rs['diffInMinutes'] = $dp1->diffInMinutes($dp2);
        $rs['diffInSeconds'] = $dp1->diffInSeconds($dp2);

        dump($rs);
    }

}