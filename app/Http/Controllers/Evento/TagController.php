<?php

namespace App\Http\Controllers\Evento;

use App\Models\Evento\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\Evento\TagRequest;
use Illuminate\Support\Facades\Storage;

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

    public function show(Tag $tag)
    {
        return view('cabinet.evento.tag.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('cabinet.evento.tag.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
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
