<?php

namespace App\Http\Controllers\SimpleTestSystem;

use App\Models\SimpleTestSystem\TestCategory;
use App\Models\SimpleTestSystem\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $attributes = $this->validateAddTest();

        $test = new Test();
        $test->parent_id = $attributes['parent_id'];
        $test->name = $attributes['name'];
        $test->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SimpleTestSystem\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(TestCategory $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SimpleTestSystem\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(TestCategory $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SimpleTestSystem\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestCategory $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SimpleTestSystem\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $simple_test_system_test)
    {
        //return $simple_test_system_test;
        $simple_test_system_test->delete();
        session()->flash('test_deleted', 'Тест (ТЗ) удален');
        return back();
    }

    //
    public function validateAddTest(){
        return \request()->validate([
            'parent_id' => 'required|int|min:1',
            'name' => 'required|string|min:3',
        ]);
    }
}
