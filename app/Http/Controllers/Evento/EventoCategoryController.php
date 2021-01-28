<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\EventoCategoryRequest;
use App\Models\Evento\EventoCategory;
use App\Models\Evento\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventoCategoryController extends Controller
{
    public function index()
    {
        $eventocategories = EventoCategory::
            leftJoin('evento_eventos','evento_eventos.id','=','evento_evento_categories.evento_id')
            ->leftJoin('evento_categories','evento_categories.id','=','evento_evento_categories.category_id')
            ->where('evento_eventos.user_id','=',auth()->id())
            ->select('evento_evento_categories.id', 'evento_evento_categories.evento_id', 'evento_evento_categories.category_id',
                 'evento_eventos.description', 'evento_categories.name as category_name')
            ->get();

        return view('cabinet.evento.eventocategory.index', compact('eventocategories'));
    }

    public function create()
    {
        $eventos = auth()->user()->eventos;
        $categories = auth()->user()->eventoCategories;

        return view('cabinet.evento.eventocategory.create', compact('eventos', 'categories'));
    }

    public function store(EventoCategoryRequest $request)
    {
        $attributes = $request->validated();

        // todo - нужно предусмотреть случай с дублированием Категории для Evento
        try{
            EventoCategory::create($attributes);
            session()->flash('crud_message',['message' => 'EventoCategory created!', 'class' => 'alert alert-success']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return back();
    }

    public function show(EventoCategory $eventocategory)
    {
        abort_if(auth()->user()->cannot('view', $eventocategory), 403);

        return view('cabinet.evento.eventocategory.show', compact('eventocategory'));
    }

    public function edit(EventoCategory $eventocategory)
    {
        abort_if(auth()->user()->cannot('update', $eventocategory), 403);

        $evento = $eventocategory->evento;

        $categories = auth()->user()->eventoCategories;

        return view('cabinet.evento.eventocategory.edit', compact('eventocategory', 'evento','categories'));
    }

    public function update(EventoCategoryRequest $request, EventoCategory $eventocategory)
    {
        abort_if(auth()->user()->cannot('update', $eventocategory), 403);

        // todo нужно предусмотреть случай с дублированием Тега для Evento

        $attributes = $request->validated();

        // ! нужно не дать user-у изменить evento_id, котоый имеет input=hidden
        $attributes['evento_id'] = $eventocategory->evento_id;

        try{
            $eventocategory->update($attributes);
            session()->flash('crud_message',['message' => 'EventoCategory updated!', 'class' => 'alert alert-warning']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return back();
    }

    public function destroy(EventoCategory $eventocategory)
    {
        abort_if(auth()->user()->cannot('delete', $eventocategory), 403);

        try{
            $eventocategory->delete();
            session()->flash('crud_message',['message' => 'EventoCategory deleted!', 'class' => 'alert alert-danger']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return redirect()->route('cabinet.evento.eventocategory.index');
    }

    public function getUserCategories()
    {
        $categories = auth()->user()->eventoCategories->toArray();

        $categoriesWithNeedColumns = [];
        $needColumns = ['id', 'parent_id', 'name'];
        foreach ($categories as $category){
            $tmp = [];
            foreach($needColumns as $column){
                if (isset($category[$column])){
                    $tmp[$column] = $category[$column];
                }
            }
            if ($tmp){
                $categoriesWithNeedColumns[] = $tmp;
            }
        }

        die(json_encode($categoriesWithNeedColumns));
    }

    public function storeAjax(EventoCategoryRequest $request)
    {
        // todo - подделка evento_id
        // todo - дублирование category - пока возможна работа только с одной категорией.
        //dd($request->all());

        // todo - тут якс запрос, если валидация не сработает json-ответ
        $attributes = $request->validated();

        $rs = ['success' => 1, 'message' => 'category success added'];
        try{
            $eventoCategory = EventoCategory::create($attributes);
            $rsCategory = Category::where('id', '=', $eventoCategory->category_id)->first();
            $rs['category_name'] = $rsCategory->name;
            $rs['eventocategory_id'] = $eventoCategory->id;
        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'storeAjax error'];
            $this->saveToLog($e);
        }

        die(json_encode($rs));
    }

    public function destroyAjax(EventoCategory $eventocategory)
    {
        $rs = ['success' => 1, 'message' => 'eventocategory success deleted!'];
        if (auth()->user()->cannot('delete', $eventocategory)){
            $rs = ['success' => 0, 'message' => 'cant delete not my own eventocategory'];
        }

        try{
            $eventocategory->delete();
        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'eventocategory delete error'];
            $this->saveToLog($e);
        }

        die(json_encode($rs));
    }

    protected function saveToLog($e){
        logger('error with ' . __METHOD__ . ' '
            . implode(' | ', [
                $e->getMessage(), $e->getLine(), $e->getCode(), $e->getFile()
            ])
        );
    }

}
