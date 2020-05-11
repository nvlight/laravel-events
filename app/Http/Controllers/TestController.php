<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testwith1(){

        return redirect()->route('test_with_2')->with('success', 'Hi there - you just now tried route()->with() method! ');
    }

    public function testwith2(){
        return view('test.test_with_1');
    }
}
