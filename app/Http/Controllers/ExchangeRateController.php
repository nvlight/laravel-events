<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    public function index(){

        // get current ExchangeRate
        $url = config('services.cbr.url_json');
        //dd($url);
        $timeout = config('services.cbr.timeout');

        $steam_context = stream_context_create(['https' => ['timeout' => $timeout]], ['http' => ['timeout' => $timeout]]);
        $rs_json = file_get_contents($url, false, $steam_context);

        $gcer = null;
        if ($rs_json !== false){
            $gcer = json_decode($rs_json, true);
        }
        //dd($gcer);

        return view('exchange-rate.index', compact('gcer'));
    }
}
