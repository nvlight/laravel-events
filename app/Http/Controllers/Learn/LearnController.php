<?php

namespace App\Http\Controllers\Learn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LearnController extends Controller
{
    //
    public function index(){
        $out = [];
        array_push($out, __NAMESPACE__);
        array_push($out, __CLASS__);
        array_push($out, __METHOD__);

        return implode(', ', $out);
    }

    public function test(){
        $out = [];
        array_push($out, __NAMESPACE__);
        array_push($out, __CLASS__);
        array_push($out, __METHOD__);
        array_push($out, '--test--');

        return implode(', ', $out);
    }
}
