<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExchangeRateController extends Controller
{
    public function index(){

        if (!file_exists(config('services.cbr.path2save_json_encoded'))
        ){
            $gcer = $this->getLastExchangeRate();
        }else{
            try {
                $gcer = json_decode(file_get_contents(config('services.cbr.path2save_json_encoded'), true), true);

                if (Carbon::parse($gcer['Date'])->diffInDays(now(), false) >= config('services.cbr.active_days') ){
                    $gcer = $this->getLastExchangeRate();
                }
            }catch (\Exception $e){
                $gcer = null;
            }
        }
        //dd($gcer);

        return view('exchange-rate.index', compact('gcer'));
    }

    //
    public function getLastExchangeRate()
    {
        $url = config('services.cbr.url_json');
        $timeout = config('services.cbr.timeout');

        $steam_context = stream_context_create(['https' => ['timeout' => $timeout]], ['http' => ['timeout' => $timeout]]);
        try {
            $rs_json = file_get_contents($url, false, $steam_context);
        }catch (\Exception $e){
            $rs_json = false;
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
