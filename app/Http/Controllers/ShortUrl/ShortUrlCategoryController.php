<?php

namespace App\Http\Controllers\ShortUrl;

use App\Models\ShortUrl\ShortUrlsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MGDebug;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ShortUrlCategoryController extends Controller
{
    // позволяет входной массив преобразовать в 3-х уровненый массив каталогов.
    protected function threeLevelTree(Array $input)
    {
        $result = [];
        $currentParentId = 0; $i = 0; $j = 0; $r = 0;
        foreach($input as $k => $v){
            if ($v['parent_id'] === $currentParentId){
                $result[$i] = $v;

                $anotherParentId = $v['id'];
                foreach($input as $kk => $vv){
                    if ($vv['parent_id'] === $anotherParentId) {
                        $result[$i]['child'][$j] = $vv;

                        $thirdParentId = $vv['id'];
                        foreach($input as $kkk => $vvv){
                            if ($vvv['parent_id'] === $thirdParentId) {
                                $result[$i]['child'][$j]['child'][$r] = $vvv;

                                $r++;
                            }
                        }

                        $j++;
                    }
                }
                $i++;
            }
        }
        return $result;
    }

    // позволяет вывести массив каталогов максимум 3-х уровневый
    protected function threeLevelTreeOutput(Array $input)
    {
        // id, user_id, parent_id, name

        // 1
        $offset = 0; $offsetInc = 5;
        foreach($input as $k => $v){
            echo str_repeat('&nbsp;', $offset) . $v['name'] . "<br>";

            // 2
            if (isset($v['child'])){
                $offset += $offsetInc;

                foreach($v['child'] as $kk => $vv){
                    echo str_repeat('&nbsp;', $offset) . $vv['name'] . "<br>";

                    // 3
                    if (isset($vv['child'])){
                        $offset += $offsetInc;

                        foreach($vv['child'] as $kkk => $vvv){
                            echo str_repeat('&nbsp;', $offset) . $vvv['name'] . "<br>";

                        }

                        $offset -= $offsetInc;
                    }

                }

                $offset -= $offsetInc;
            }
        }
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
        $shortUrlsArrTree = $this->threeLevelTree($shortUrlsArr);

        //$this->threeLevelTreeOutput($result);
        //echo MGDebug::d($result); die;
        //echo MGDebug::d($shortUrlIds); die;

        return view('shorturl_new.category.index', ['shortUrlIds' => $shortUrlIds,
            'shortUrlsArrTree' => $shortUrlsArrTree,
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
