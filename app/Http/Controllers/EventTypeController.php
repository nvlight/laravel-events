<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventTypeRequestStore;
use App\Models\Event\Type;

class EventTypeController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function create()
    {
    }

    public function store(EventTypeRequestStore $request)
    {
        $attributes = $request->validated();

        $attributes += ['user_id' => auth()->id()];

        Type::create($attributes);
        session()->flash('type_created','Тип события добавлен!');

        return back();
    }

    public function show(Type $type)
    {
    }

    public function edit(Type $type)
    {
        return view('type.edit',compact('type'));
    }

    public function update(EventTypeRequestStore $request, Type $type)
    {
        $attributes = $request->validated();

        $type->name = $attributes['name'];
        $type->color = $attributes['color'];
        $type->save();

        session()->flash('type_updated','Тип события обновлен!');

        return back();
    }

    public function destroy(Type $type)
    {
        $type->delete();
        session()->flash('type_deleted','Тип события удалено!');
        return redirect('/category');
    }

}
