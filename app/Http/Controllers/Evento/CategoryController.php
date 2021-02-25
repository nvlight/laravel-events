<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\CategoryRequest;
use App\Models\Evento\Category;
use App\Http\Controllers\Controller;
use App\Models\Evento\EventoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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

    public function getAjax($id)
    {
        try{
            $category = Category::find($id);
        }catch (\Exception $e){
            $this->saveToLog($e);
            $rs = ['success' => 0, 'message' => 'Category not finded!'];
            die(json_encode($rs));
        }

        if (auth()->user()->cannot('view', $category)){
            $rs = ['success' => 0, 'message' => 'Access denied!'];
            die(json_encode($rs));
        }

        $rs = ['success' => 1, 'message' => 'category finded!', 'category' => $category->toArray()];
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

    public function updateAjax($categoryId, Request $request)
    {
        try{
            $category = Category::find($categoryId);
        }catch (\Exception $e){
            $this->saveToLog($e);
            $rs = ['success' => 0, 'message' => 'Category not finded!',];
            die(json_encode($rs));
        }
        //die(json_encode(['success' => 0, 'message' => 'Unkoun error!', 'oldCategory' => $category->toArray(), ]));

        if (auth()->user()->cannot('update', $category)){
            $rs = ['success' => 0, 'message' => 'Access denied!',];
            die(json_encode($rs));
        }

        $validator = Validator::make($request->all(), $this->validatorRules());

        if ($validator->fails()){
            $rs = ['success' => 0, 'message' => 'Validation error!', 'oldCategory' => $category->toArray(),
                'errors' => $validator->errors()->toArray(), ];
            die(json_encode($rs));
        }

        try {
            $category->name = $request->input('name');
            $category->save();
            $result = ['success' => 1, 'name' => $category->name, 'categoryId' => $category->id,
                'message' => 'category updated!', 'category' => $category,
            ];
        }catch (\Exception $e){
            $result = ['success' => 0, 'message' => 'Save Error!', 'oldCategory' => $category->toArray(),];
            $this->saveToLog($e);
        }

        die(json_encode($result));
    }

    public function validateAjax(){
        return \request()->validate($this->validatorRules());
    }

    public function validatorRules(){
        $img = [
            'dimensions' => [
                'min' => [
                    'width'  => 10,
                    'height' => 10
                ],
                'max' => [
                    'width'  => 100,
                    'height' => 100
                ],
            ],
            'size' => [
                'min' => 0,
                'max' => 2048
            ]
        ];
        $rules = [
            'name' => ['required', 'string', 'max:105', 'min:2'],
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|min:' . $img['size']['min'] .
                '|max:' . $img['size']['max'] .
                '|dimensions:' .
                'min_width=' . $img['dimensions']['min']['width'] . ',min_height=' . $img['dimensions']['min']['height'] .
                ',max_width=' . $img['dimensions']['max']['width'] . ',max_height=' . $img['dimensions']['max']['height'],
        ];
        return $rules;
    }

    protected function saveToLog($e){
        logger('error with ' . __METHOD__ . ' '
            . implode(' | ', [
                $e->getMessage(), $e->getLine(), $e->getCode(), $e->getFile()
            ])
        );
    }
}
