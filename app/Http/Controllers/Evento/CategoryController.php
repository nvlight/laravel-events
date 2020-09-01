<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\CategoryRequest;
use App\Models\Evento\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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

        if ($request->hasFile('img')){
            $savedImgPath = $request->file('img')
                ->store(auth()->id(), ['disk' => 'local'] );
            $attributes['img'] = $savedImgPath;
        }

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

        $attributes['slug'] = Str::slug($attributes['name']);

        if ($request->hasFile('img')){
            $savedImgPath = $request->file('img')
                ->store(auth()->id(), ['disk' => 'local'] );
            $attributes['img'] = $savedImgPath;

            $this->deleteImg($category);
        }

        $category->update($attributes);

        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();

        $this->deleteImg($category);

        return back();
    }

    protected function deleteImg(Category $category)
    {
        if (Storage::disk('local')->exists($category->img)){
            return Storage::disk('local')->delete($category->img);
        }
        return false;
    }
}
