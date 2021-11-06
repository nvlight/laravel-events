<?php

namespace App\Http\Controllers\ShortUrl;

use App\Models\ShortUrl\ShortUrlsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MGDebug;
use Illuminate\Support\Str;

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

        return view('shorturl_new.index', ['shortUrlIds' => $shortUrlIds,
            'shortUrlsArrTree' => $shortUrlsArrTree,
        ]);
    }

    public function create()
    {
        return view('shorturl_new.create');
    }

    public function store(Request $request)
    {
        $attributes = $this->validateForStoreShortUrl();

        $attributes['name'] = $request->get('name');
        $attributes['slug'] = Str::slug($attributes['name']);
        $attributes += ['user_id' => auth()->id()];
        ShortUrlsCategory::create($attributes);

        session()->flash('shorturlnew_created','Категория создана');
        return back();
    }

    public function validateForStoreShortUrl()
    {
        return \request()->validate([
            'name' => 'required|string|min:3|max:170',
            'parent_id' => 'required|int|min:0',
        ]);
    }

    public function show(ShortUrlsCategory $shortUrlCategory)
    {
        //
    }

    public function edit(ShortUrlsCategory $shortUrlCategory)
    {
        //
    }

    public function update(Request $request, ShortUrlsCategory $shortUrlCategory)
    {
        //
    }

    public function destroy(int $shortUrlCategoryId)
    {
        $category = ShortUrlsCategory::findOrFail($shortUrlCategoryId);

        abort_if(auth()->user()->cannot('delete', $category), 403);

        $category->delete();
        session()->flash('shorturlnew_deleted','Категория удалена!');
        return redirect()->route('shorturlnew.index');

    }
}
