<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\EventoCategoryRequest;
use App\Http\Requests\Evento\EventoTagRequest;
use App\Models\Evento\Evento;
use App\Models\Evento\EventoCategory;
use App\Models\Evento\EventoTag;
use App\Models\Evento\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

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

        // todo - нужно предусмотреть случай с дублированием Тега для Evento

        EventoCategory::create($attributes);

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

        // - нужно предусмотреть случай с дублированием Тега для Evento

        $attributes = $request->validated();

        // todo + нужно не дать user-у изменить evento_id, котоый имеет input=hidden
        $attributes['evento_id'] = $eventocategory->evento_id;

        $eventocategory->update($attributes);

        return back();
    }

    public function destroy(EventoCategory $eventocategory)
    {
        abort_if(auth()->user()->cannot('delete', $eventocategory), 403);

        $eventocategory->delete();

        return back();
    }

    // toDo -- remove later
    public function destroyAjaxTest(EventoCategory $eventocategory)
    {
        $rs = ['success' => 1, 'message' => 'eventocategory success deleted!'];
        if (auth()->user()->cannot('delete', $eventocategory)){
            $rs = ['success' => 0, 'message' => 'cant delete not my own eventocategory'];
        }

        $eventocategory->delete();

        die(json_encode($rs));
    }

    /**
     *  Получение списка категорий пользователя
     */
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

    /**
     *  Сохранение новой категории
     */
    public function storeAjax(EventoCategoryRequest $request)
    {
        // todo - подделка evento_id
        // todo - дублирование category - пока возможна работа только с одной категорией.
        //dd($request->all());

        $attributes = $request->validated();

        $rs = ['success' => 1, 'message' => 'category success added'];
        try{
            $eventoCategory = EventoCategory::create($attributes);
            $rsCategory = Category::where('id', '=', $eventoCategory->category_id)->first();
            $rs['category_name'] = $rsCategory->name;
            $rs['eventocategory_id'] = $eventoCategory->id;
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

    /**
     *  Удаление категории
     */
    public function destroyAjax(EventoCategory $eventocategory)
    {
        $rs = ['success' => 1, 'message' => 'eventocategory success deleted!'];
        if (auth()->user()->cannot('delete', $eventocategory)){
            $rs = ['success' => 0, 'message' => 'cant delete not my own eventocategory'];
        }

        $eventocategory->delete();

        die(json_encode($rs));
    }

}
