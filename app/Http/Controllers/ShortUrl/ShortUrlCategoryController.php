<?php

namespace App\Http\Controllers\ShortUrl;

use App\Models\ShortUrl\ShortUrlsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MGDebug;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ShortUrlCategoryController extends Controller
{
    // Преобразует входный массив в многомерный с дочерними элементами
    protected function makeTree($data, $pid, &$result)
    {
        $i = 0;
        foreach($data as $k => $v){
            if ($v['parent_id'] === $pid){

                $result['child'][$i] = $v;

                $this->makeTree($data, $v['id'], $result['child'][$i]);

                $i++;
            }
        }
    }

    // рекурсивная функция обхода дерева массивов и их рендер по шаблону
    protected function outTreeRec(Array $input, &$output, $repeatStr, $offset, $offsetInc = 3)
    {
        // ['item' => $v, 'repeatStr' => $repeatStr, 'offset' => $offset ]
        if (isset($input['child'])){
            foreach($input['child'] as $k => $v){
                $output .= View::make('shorturl_new.category.categoryLine_withStyle',
                    ['item' => $v, 'repeatStr' => $repeatStr, 'offset' => $offset, 'offsetInc' => $offsetInc ])
                ->render();

                $offset += $offsetInc;
                $this->outTreeRec($v, $output, $repeatStr, $offset, $offsetInc);
                $offset -= $offsetInc;
            }
        }
    }

    // Получение строки из дерева категорий
    protected function outTree(Array $input)
    {
        $result = "";

        if (!isset($input['child'])) {
            return $result;
        }

        // вывод по старому стилю :smirk
        //$result = View::make('shorturl_new.category.table-data', ['shortUrlsArrTree' => $input ])->render();

        $offset = 0; $offsetInc = 3; $repeatStr = '-';
        $this->outTreeRec($input, $result, $repeatStr, $offset, $offsetInc);

        return $result;
    }

    public function index()
    {
        $shorturls = ShortUrlsCategory::
            where('user_id','=', auth()->id())
            ->get();

        $shortUrlIds = ShortUrlsCategory::
        where('user_id', auth()->id() )
            ->pluck('name', 'id')
            ->toArray()
        ;

        $shortUrlsArr = $shorturls->toArray();

        $shortUrlsArrTree = [];
        $this->makeTree($shortUrlsArr, 0, $shortUrlsArrTree);

        $outputData = $this->outTree($shortUrlsArrTree);

        return view('shorturl_new.category.index', ['shortUrlIds' => $shortUrlIds,
            'shortUrlsArrTree' => $shortUrlsArrTree, 'tableData' => $outputData,
        ]);
    }

    public function create()
    {
        return view('shorturl_new.category.create');
    }

    public function createWithParent(int $parentId)
    {
        $parent = ShortUrlsCategory::findOrFail($parentId);

        return view('shorturl_new.category.createWithParent', ['parent' => $parent]);
    }

    public function store(Request $request)
    {
        $attributes = $this->validateForStoreShortUrl();

        $attributes['name'] = $request->get('name');
        $attributes['slug'] = Str::slug($attributes['name']);
        $attributes += ['user_id' => auth()->id()];
        ShortUrlsCategory::create($attributes);

        session()->flash('shorturlnew_category_created','Категория создана');
        return back();
    }

    public function storeWithParent(Request $request)
    {
        $parent = ShortUrlsCategory::findOrFail($request['parent_id']);

        $attributes = $this->validateForStoreShortUrl();

        $attributes['name'] = $request->get('name');
        $attributes['slug'] = Str::slug($attributes['name']);
        $attributes['parent_id'] = $parent->id;
        $attributes += ['user_id' => auth()->id()];
        ShortUrlsCategory::create($attributes);

        session()->flash('shorturlnew_category_createdWithParent','Категория с фиксированным id предка создана');
        return redirect()->route('shorturlnew_category.index');
    }

    public function validateForStoreShortUrl()
    {
        return \request()->validate([
            'name' => 'required|string|min:3|max:170',
            'parent_id' => 'required|int|min:0',
        ]);
    }

    public function show(int $shortUrlCategory)
    {
        $category = ShortUrlsCategory::findOrFail($shortUrlCategory);

        return view('shorturl_new.category.show', ['category' => $category]);
    }

    public function edit(int $shortUrlCategory)
    {
        $category = ShortUrlsCategory::findOrFail($shortUrlCategory);

        abort_if(auth()->user()->cannot('update', $category), 403);

        return view('shorturl_new.category.edit', compact('category'));
    }

    public function update(Request $request, int $shortUrlCategory)
    {
        $category = ShortUrlsCategory::findOrFail($shortUrlCategory);

        abort_if(auth()->user()->cannot('update', $category), 403);

        $attributes = $this->validateForStoreShortUrl();

        $category->name = $attributes['name'];
        $category->parent_id = $attributes['parent_id'];
        $category->save();

        session()->flash('shorturlnew_category_updated', 'Категория обновлена');

        return redirect()->route('shorturlnew_category.edit', $category->id);
    }

    public function destroy(int $shortUrlCategoryId)
    {
        $category = ShortUrlsCategory::findOrFail($shortUrlCategoryId);

        abort_if(auth()->user()->cannot('delete', $category), 403);

        //$category->delete();
        try {
            $ids = $this->cascadeDestroy($category->id);
            session()->flash('shorturlnew_deleted','Категория удалена!');
            //echo MGDebug::d($ids); die;

            if ($this->deleteByIds($ids) === false ){
                session()->flash('shorturlnew_deleted','Ошибка при каскадном удалении категории!');
            }
        }catch (\Exception $e){
            session()->flash('shorturlnew_deleted','Ошибка при удалении категории!');
        }

        return redirect()->route('shorturlnew_category.index');
    }

    protected function deleteByIds(Array $ids)
    {
        try {
            $exception = DB::transaction(function() use($ids) {
                ShortUrlsCategory::destroy($ids);
            });

            return is_null($exception) ? true : $exception;

        } catch(Exception $e) {
            return false;
        }

        //DB::transaction(function () use($ids) {
        //    ShortUrlsCategory::destroy($ids);
        //});
    }

    protected function cascadeDestroyHandler(int $currentId, Array $arr, Array & $ids)
    {
        $ids[] = $currentId;
        foreach($arr as $k => $v){
            if ($v === $currentId){
                $this->cascadeDestroyHandler($k, $arr, $ids);
            }
        }
    }

    public function cascadeDestroy(int $id=0)
    {
        $ids = [];
        $categories = ShortUrlsCategory::
            where('user_id', auth()->id() )
            ->pluck('parent_id', 'id')
            ->toArray()
        ;
        //echo MGDebug::d($categories); die;

        $this->cascadeDestroyHandler($id, $categories, $ids);


        return $ids;
    }
}
