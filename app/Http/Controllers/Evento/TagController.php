<?php

namespace App\Http\Controllers\Evento;

use App\Models\Evento\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\Evento\TagRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = auth()->user()->eventoTags;

        return view('cabinet.evento.tag.index', compact('tags'));
    }

    public function create()
    {
        return view('cabinet.evento.tag.create');
    }

    public function store(TagRequest $request)
    {
        $attributes = $request->validated();
        $attributes += ['user_id' => auth()->id()];

        if ($request->hasFile('img')){
            $savedImgPath = $request->file('img')
                ->store(auth()->id(), ['disk' => 'local'] );
            $attributes['img'] = $savedImgPath;
        }

        Tag::create($attributes);

        return back();
    }

    public function storeAjax(TagRequest $request)
    {
        $attributes = $request->validated();

        $rs = ['success' => 1, 'message' => 'Тег добавлен!'];
        try{
            $attributes += ['slug' => Str::slug($attributes['name'])];
            $attributes += ['user_id' => auth()->id()];

            $category = Tag::create($attributes);
            $rs['tag_name'] = $category->name;

            if ($request->hasFile('img')){
                $savedImgPath = $request->file('img')
                    ->store(auth()->id(), ['disk' => 'local'] );
                $attributes['img'] = $savedImgPath;
            }

        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'error'];
            logger('error with ' . __METHOD__ . ' '
                . implode(' | ', [
                    $e->getMessage(), $e->getLine(), $e->getCode(), $e->getFile()
                ])
            );
        }

        die(json_encode($rs));
    }

    public function show(Tag $tag)
    {
        abort_if(auth()->user()->cannot('view', $tag), 403);

        return view('cabinet.evento.tag.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        abort_if(auth()->user()->cannot('update', $tag), 403);

        return view('cabinet.evento.tag.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        abort_if(auth()->user()->cannot('update', $tag), 403);

        $attributes = $request->validated();

        if ($request->hasFile('img')){
            $savedImgPath = $request->file('img')
                ->store(auth()->id(), ['disk' => 'local'] );
            $attributes['img'] = $savedImgPath;

            $this->deleteImg($tag);
        }

        $tag->update($attributes);

        return back();
    }

    public function destroy(Tag $tag)
    {
        abort_if(auth()->user()->cannot('delete', $tag), 403);

        $tag->delete();

        $this->deleteImg($tag);

        return back();
    }

    protected function deleteImg(Tag $tag)
    {
        if (Storage::disk('local')->exists($tag->img)){
            return Storage::disk('local')->delete($tag->img);
        }
        return false;
    }
}
