<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index(){
        return __CLASS__ . __METHOD__;
    }


}