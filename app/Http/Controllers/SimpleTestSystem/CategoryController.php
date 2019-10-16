<?php

namespace App\Http\Controllers\SimpleTestSystem;

use App\Models\SimpleTestSystem\Question;
use App\Models\SimpleTestSystem\QuestionType;
use App\Models\SimpleTestSystem\Test;
use App\Models\SimpleTestSystem\TestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $question_types = QuestionType::all();
        //dd($question_types);
        $categories = TestCategory::where('id','>=',0)->orderby('id','asc')->get();
        $tests = Test::where('id','>=',0)
            ->orderBy('id','desc')
            ->get();
        //dd($categories->toArray());
        //dd($tests);

        return view('simpletestsystem.test.index', compact('categories', 'tests','question_types'));
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
        //
        $attributes = $this->validateAddTestCategory();

        $testCategory = new TestCategory();
        $testCategory->parent_id = $attributes['parent_id'];
        $testCategory->name = $attributes['name'];
        $testCategory->save();
        session()->flash('testcategory_created', 'Категория создана');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SimpleTestSystem\TestCategory  $testCategory
     * @return \Illuminate\Http\Response
     */
    public function show(TestCategory $testCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SimpleTestSystem\TestCategory  $testCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(TestCategory $testCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SimpleTestSystem\TestCategory  $testCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestCategory $testCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SimpleTestSystem\TestCategory  $testCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestCategory $simple_test_system)
    {
        //return $simple_test_system;
        $simple_test_system->delete();
        session()->flash('testcategory_deleted', 'Категория удалена');
        return back();
    }

    public function validateAddTestCategory(){
        return \request()->validate([
            'parent_id' => 'required|int|min:0',
            'name' => 'required|string|min:3',
        ]);
    }
}
