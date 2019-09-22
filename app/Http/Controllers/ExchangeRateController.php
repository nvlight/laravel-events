<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    public function index(){

        return view('exchange-rate.index');
    }
}
