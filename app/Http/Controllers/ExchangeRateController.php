<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $gcer = null;
        return view('exchange-rate.index', compact('gcer'));
    }

    //
    public function getLastExchangeRateHtml()
    {
        $gcer = $this->getLastExchangeRate();

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
        }

        $gcer = null;
        if ($rs_json !== false) {
            try {
                $gcer = json_decode($rs_json, true);
                $filename = config('services.cbr.path2save') . '/' . config('services.cbr.filename');
                Storage::disk('local')->put($filename, $rs_json);
            }catch (\Exception $e){
                $gcer = null;
            }
        }

        return $gcer;
    }

}
