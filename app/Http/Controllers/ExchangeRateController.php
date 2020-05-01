<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $gcer = null;
        $html = '';

//        if (!file_exists(config('services.cbr.path2save_json_encoded'))
//        ){
//            $gcer = $this->getLastExchangeRate();
//        }else{
//            try {
//                $gcer = json_decode(file_get_contents(config('services.cbr.path2save_json_encoded'), true), true);
//
//                if (Carbon::parse($gcer['Date'])->diffInDays(now(), false) >= config('services.cbr.active_days') ){
//                    $gcer = $this->getLastExchangeRate();
//                }
//            }catch (\Exception $e){
//                $gcer = null;
//            }
//        }
        return view('exchange-rate.index', compact('gcer'));
        //return $html;
    }

    //
    public function getLastExchangeRateHtml()
    {
        $gcer = $this->getLastExchangeRate();

        //dump($gcer);

        $gcerResultHtmlRender = View::make('exchange-rate.index2', compact('gcer') )->render();
        $gcerHtml = json_encode(['html' => $gcerResultHtmlRender]);

        return $gcerHtml;
    }

    //
    public function getLastExchangeRate()
    {
        $url = config('services.cbr.url_json');
        $timeout = config('services.cbr.timeout');

        $streamContextOptions = [
            'ssl'   => ['verify_peer' => false,  'verify_peer_name' => true, ],
            'https' => ['timeout' => $timeout],
            'http'  => ['timeout' => $timeout],
        ];
        try {
            $rs_json = file_get_contents($url, false, stream_context_create($streamContextOptions));
        }catch (\Exception $e){
            $rs_json = false;
            //dump($e);
        }

        $gcer = null;
        if ($rs_json !== false) {
            try {
                $gcer = json_decode($rs_json, true);
                file_put_contents(config('services.cbr.path2save_json_encoded'), $rs_json);
            }catch (\Exception $e){
                $gcer = null;
            }
        }

        return $gcer;
    }

}
