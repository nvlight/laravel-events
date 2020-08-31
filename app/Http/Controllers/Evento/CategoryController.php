<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\CategoryRequest;
use App\Models\Evento\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->eventoCategories;

        return view('cabinet.evento.category.index', compact('categories'));
    }

    public function create()
    {
        $categoryIds = auth()->user()->eventoCategories()->pluck('id')->toArray();

        return view('cabinet.evento.category.create', compact('categoryIds'));
    }

    public function store(CategoryRequest $request)
    {
        $attributes = $request->validated();

        $attributes += ['slug' => Str::slug($attributes['name'])];
        $attributes += ['user_id' => auth()->id()];

        Category::create($attributes);

        return back();
    }

    public function show(Category $category)
    {
        return view('cabinet.evento.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categoryIds = Category::all()->pluck('id')->toArray();

        return view('cabinet.evento.category.edit', compact('category', 'categoryIds'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $attributes = $request->validated();

        $attributes += ['slug' => Str::slug($attributes['name'])];

        $category->update($attributes);

        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back();
    }
}
