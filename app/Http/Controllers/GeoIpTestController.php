<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class GeoIpTestController extends Controller
{

    //
    public function index(){
        $position1 = Location::get('https://www.itv.ru/products/ip/');
        $position2 = Location::get('167.86.118.175');

        dump($position1);
        dump($position2);
        //dd('okey than!');
        //return view('GeoIpTest.index');
    }

}