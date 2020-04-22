<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventTypeRequestStore;
use App\Models\Event\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function store(EventTypeRequestStore $request)
    {
        //$attributes = $this->validateType();
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
        //$attributes = $this->validateType();
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
        session()->flash('type_deleted','Событие удалено!');
        return redirect('/category');
    }

}
