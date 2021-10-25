<?php

namespace App\Http\Controllers\Learn;

use App\testModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\testModel  $testModel
     * @return \Illuminate\Http\Response
     */
    public function show(testModel $testModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\testModel  $testModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, testModel $testModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\testModel  $testModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(testModel $testModel)
    {
        //
    }
}
