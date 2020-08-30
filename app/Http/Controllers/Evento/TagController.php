<?php

namespace App\Http\Controllers\Evento;

use App\Models\Evento\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\Evento\TagRequest;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

        return view('cabinet.evento.tag.index', compact('tags'));
    }

    public function create()
    {
        return view('cabinet.evento.tag.create.index');
    }

    public function store(TagRequest $request)
    {
        $attributes = $request->validated();

        Tag::create($attributes);

        return back()->with('event_tag_created', 'event_tag_created');
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

        $tag->update($attributes);

        return back()->with('event_tag_updated', 'event_tag_updated');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return back()->with('event_tag_deleted', 'event_tag_deleted');
    }
}
