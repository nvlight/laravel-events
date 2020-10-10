<?php

namespace App\Http\Controllers\Bootstrap5;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Bootstrap5 extends Controller
{
    public function index()
    {
        return view('bootstrap5.index');
    }
}
