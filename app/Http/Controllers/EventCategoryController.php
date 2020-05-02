<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCategoryRequest;
use App\Models\Event\Category;

class EventCategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->categories;
        $types = auth()->user()->types;

        return view('category.index', compact('categories','types'));
    }

    public function create()
    {
    }

    public function store(EventCategoryRequest $request)
    {
        $attributes = $request->validated();

        $attributes += ['user_id' => auth()->id()];

        Category::create($attributes);

        session()->flash('category_created','Категория добавлена!');

        return back();
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        return view('category.edit',compact('category'));
    }

    public function update(EventCategoryRequest $request, Category $category)
    {
        $attributes = $request->validated();

        $category->name = $attributes['name'];
        $category->save();

        session()->flash('category_updated','Категория обновлена!');

        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('category_deleted','Категория удалена!');
        return redirect('/category');
    }

}
