<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\CategoryRequest;
use App\Models\Evento\Category;
use App\Http\Controllers\Controller;
use App\Models\Evento\EventoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->eventoCategories;

        return view('cabinet.evento.category.index', compact('categories'));
    }

    public function indexAjax()
    {
        $categories = auth()->user()->eventoCategories;

        $rs = ['success' => 1, 'message' => 'Категории получены!'];

        $catsRender = View::make('cabinet.evento.ajax.category_list', compact('categories'))
            ->render();

        $rs['categories'] = $catsRender;

        die(json_encode($rs));
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

        try{
            if ($request->hasFile('img')){
                $savedImgPath = $request->file('img')
                    ->store(auth()->id(), ['disk' => 'local'] );
                $attributes['img'] = $savedImgPath;
            }

            Category::create($attributes);
            session()->flash('crud_message',['message' => 'Tag stored!', 'class' => 'alert alert-success']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return redirect()->route('cabinet.evento.category.index');
    }

    public function storeAjax(CategoryRequest $request)
    {
        try{
            $rs = ['success' => 1, 'message' => 'Категория добавлена!'];

            $attributes = $request->validated();

            $attributes += ['slug' => Str::slug($attributes['name'])];
            $attributes += ['user_id' => auth()->id()];

            $category = Category::create($attributes);
            $rs['category_name'] = $category->name;

            if ($request->hasFile('img')){
                $savedImgPath = $request->file('img')
                    ->store(auth()->id(), ['disk' => 'local'] );
                $attributes['img'] = $savedImgPath;
            }

            session()->flash('crud_message',['message' => 'Tag stored!', 'class' => 'alert alert-success']);
        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'error'];
            $this->saveToLog($e);
        }

        die(json_encode($rs));
    }

    public function show(Category $category)
    {
        abort_if(auth()->user()->cannot('view', $category), 403);

        return view('cabinet.evento.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        abort_if(auth()->user()->cannot('update', $category), 403);

        $categoryIds = Category::all()->pluck('id')->toArray();

        return view('cabinet.evento.category.edit', compact('category', 'categoryIds'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        abort_if(auth()->user()->cannot('update', $category), 403);

        $attributes = $request->validated();

        $attributes['slug'] = Str::slug($attributes['name']);

        try{
            if ($request->hasFile('img')){
                $savedImgPath = $request->file('img')
                    ->store(auth()->id(), ['disk' => 'local'] );
                $attributes['img'] = $savedImgPath;

                $this->deleteImg($category);
            }
            $category->update($attributes);

            session()->flash('crud_message',['message' => 'Tag updated!', 'class' => 'alert alert-warning']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return back();
    }

    public function destroy(Category $category)
    {
        abort_if(auth()->user()->cannot('delete', $category), 403);

        try{
            $category->delete();
            $this->deleteImg($category);

            session()->flash('crud_message',['message' => 'Tag deleted!', 'class' => 'alert alert-danger']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return redirect()->route('cabinet.evento.category.index');
    }

    public function destroyAjax(Category $category)
    {
        abort_if(auth()->user()->cannot('delete', $category), 403);

        try{
            // теперь нужно получить id-шники, которые соответствуют таблице eventoCategory
            $evIds = EventoCategory::where('category_id', $category->id)
                ->pluck('id');

            $category->delete();
            $this->deleteImg($category);
            $rs = ['success' => 1, 'message' => 'Category deleted!', 'id' => $category->id];

            $rs['evIds'] = $evIds;

            session()->flash('crud_message',['message' => 'Tag deleted!', 'class' => 'alert alert-danger']);
        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'error'];
            $this->saveToLog($e);
        }

        die(json_encode($rs));
    }

    protected function deleteImg(Category $category)
    {
        if (Storage::disk('local')->exists($category->img)){
            return Storage::disk('local')->delete($category->img);
        }
        return false;
    }

    public function getChangeCategoryButtonsHtml()
    {
        $confirmButton = View::make('cabinet.evento._other.button.confirm-button',
            ['class' => 'add-category-crud--confirm color-green curp', 'style' => 'margin-top: 1px'])
                ->render();

        $cancelButton = View::make('cabinet.evento._other.button.cancel-button',
            ['class' => 'add-category-crud--cancel color-red curp', 'style' => 'margin-left: 2px'])
                ->render();

        $rs['buttons'] = View::make('cabinet.evento._other.button.add_category_crud_buttons',
            ['confirmButton' => $confirmButton, 'cancelButton' =>  $cancelButton, 'class' => "d-flex align-items-center"]
            )->render();

        $rs['success'] = 1;

        die(json_encode($rs));
    }

    public function editCategoryAjax(Category $category, Request $request)
    {
        try {
            $category->name = $request->input('name');
            $category->save();
            $result = ['success' => 1, 'name' => $category->name, 'categoryId' => $category->id];

            session()->flash('crud_message',['message' => 'Tag updated!', 'class' => 'alert alert-warning']);
        }catch (\Exception $e){
            $result = ['success' => 0, 'message' => 'editCategoryAjax error!'];
            $this->saveToLog($e);
        }

        die(json_encode($result));
    }

    protected function saveToLog($e){
        logger('error with ' . __METHOD__ . ' '
            . implode(' | ', [
                $e->getMessage(), $e->getLine(), $e->getCode(), $e->getFile()
            ])
        );
    }
}
