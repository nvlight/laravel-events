<?php

namespace App\Http\Controllers\Natpot;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NatpotController extends Controller
{
    public function index()
    {
        return view('natpot.index');
    }

    public function calculate(Request $request)
    {
        dd($request->all());

        return view('natpot.index');
    }
}
