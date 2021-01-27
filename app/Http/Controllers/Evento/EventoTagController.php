<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\EventoTagRequest;
use App\Models\Evento\EventoTag;
use App\Models\Evento\EventoTagValue;
use App\Models\Evento\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class EventoTagController extends Controller
{
    public function index()
    {
        $eventotags = EventoTag::
            leftJoin('evento_eventos','evento_eventos.id','=','evento_evento_tags.evento_id')
            ->leftJoin('evento_tags','evento_tags.id','=','evento_evento_tags.tag_id')
            ->where('evento_eventos.user_id','=',auth()->id())
            ->select('evento_evento_tags.id', 'evento_evento_tags.evento_id', 'evento_evento_tags.tag_id',
                 'evento_eventos.description', 'evento_tags.name as tag_name')
            ->get();

        return view('cabinet.evento.eventotag.index', compact('eventotags'));
    }
    public function create()
    {
        $eventos = auth()->user()->eventos;
        $tags = auth()->user()->eventoTags;

        return view('cabinet.evento.eventotag.create', compact('eventos', 'tags'));
    }

    public function store(EventoTagRequest $request)
    {
        $attributes = $request->validated();

        // todo - нужно предусмотреть случай с дублированием Тега для Evento
        try{
            EventoTag::create($attributes);
            session()->flash('crud_message',['message' => 'EventoTag created!', 'class' => 'alert alert-success']);
        }catch (\Exception $e){
            $this->saveToLog($e);
            session()->flash('crud_message',['message' => 'EventoTag create error!', 'class' => 'alert alert-danger']);
        }

        return back();
    }

    public function storeAjax(EventoTagRequest $request)
    {
        // todo

        $attributes = $request->validated();

        $rs = ['success' => 1, 'message' => 'tag success added'];
        $result = null;
        try{
            if ($request->has('value') && ( $request->get('value') !== null) ){
                // нужно написать транзакцию, чтобы сразу же записать в таблицу EventoTagValue!
                $tagValue   = $request->get('value');
                $tagCaption = $request->get('caption');
                \DB::transaction(function () use($attributes, $tagValue, $tagCaption, &$result) {
                    $eventoTag = EventoTag::create($attributes);
                    $rsTag = Tag::where('id', '=', $eventoTag->tag_id)->first();

                    $rs = ['success' => 1, 'message' => 'tag success added'];
                    $rs['tag_name'] = $rsTag->name;
                    $rs['eventotag_id'] = $eventoTag->id;
                    $rs['tag_color'] = $rsTag->color;
                    $rs['tag_value'] = $tagValue;
                    $result = $rs;

                    $etv = EventoTagValue::find($eventoTag->id);
                    if (!$etv){
                        $etv = new EventoTagValue();
                        $etv->evento_evento_tags_id = $eventoTag->id;
                        $etv->value = $tagValue;
                        $etv->caption = $tagCaption;
                        $etv->save();
                    }else{
                        $etv->value = $tagValue;
                        $etv->save();
                    }
                });
            }else{
                $eventoTag = EventoTag::create($attributes);
                $rsTag = Tag::where('id', '=', $eventoTag->tag_id)->first();
                $rs['tag_name'] = $rsTag->name;
                $rs['eventotag_id'] = $eventoTag->id;
                $rs['tag_color'] = $rsTag->color;
                $result = $rs;
            }
            $rs['eventoTagDiv'] = View::make('cabinet.evento.ajax.eventotag_table_item', ['tag' => $result])->render();

        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'error'];
            $this->saveToLog($e);
        }

        die(json_encode($rs));
    }

    public function show(EventoTag $eventotag)
    {
        abort_if(auth()->user()->cannot('view', $eventotag), 403);

        return view('cabinet.evento.eventotag.show', compact('eventotag'));
    }

    public function edit(EventoTag $eventotag)
    {
        abort_if(auth()->user()->cannot('update', $eventotag), 403);

        $evento = $eventotag->evento;
        //dd($evento);
        $tags = auth()->user()->eventoTags;

        return view('cabinet.evento.eventotag.edit', compact('eventotag', 'evento','tags'));
    }

    public function update(EventoTagRequest $request, EventoTag $eventotag)
    {
        abort_if(auth()->user()->cannot('update', $eventotag), 403);

        // - нужно предусмотреть случай с дублированием Тега для Evento

        $attributes = $request->validated();

        // + нужно не дать user-у изменить evento_id, котоый имеет input=hidden
        $attributes['evento_id'] = $eventotag->evento_id;

        try{
            $eventotag->update($attributes);
            session()->flash('crud_message',['message' => 'EventoTag updated!', 'class' => 'alert alert-success']);
        }catch (\Exception $e){
            $this->saveToLog($e);
            session()->flash('crud_message',['message' => 'EventoTag update error!', 'class' => 'alert alert-danger']);
        }

        return back();
    }

    public function destroy(EventoTag $eventotag)
    {
        abort_if(auth()->user()->cannot('delete', $eventotag), 403);

        try{
            $eventotag->delete();
            session()->flash('crud_message',['message' => 'EventoTag deleted!', 'class' => 'alert alert-danger']);
        }catch (\Exception $e){
            $this->saveToLog($e);
            session()->flash('crud_message',['message' => 'EventoTag delete error!', 'class' => 'alert alert-danger']);
        }

        return redirect()->route('cabinet.evento.eventotag.index');
    }

    /**
     *  Удаление категории
     */
    public function destroyAjax(EventoTag $eventotag)
    {
        $rs = ['success' => 1, 'message' => 'eventotag success deleted!'];
        if (auth()->user()->cannot('delete', $eventotag)){
            $rs = ['success' => 0, 'message' => 'cant delete not my own eventotag'];
        }

        try{
            $eventotag->delete();
            session()->flash('crud_message',['message' => 'EventoTag deleted!', 'class' => 'alert alert-danger']);
        }catch (\Exception $e){
            $this->saveToLog($e);
            $rs = ['success' => 0, 'message' => 'EventoTag delete error!'];
            session()->flash('crud_message',['message' => 'EventoTag delete error!', 'class' => 'alert alert-danger']);
        }

        die(json_encode($rs));
    }

    /**
     *  Получение списка категорий пользователя
     */
    public function getUserTags()
    {
        $categories = auth()->user()->eventoTags->toArray();

        $tagsWithNeedColumns = [];
        $needColumns = ['id', 'parent_id', 'name'];
        foreach ($categories as $category){
            $tmp = [];
            foreach($needColumns as $column){
                if (isset($category[$column])){
                    $tmp[$column] = $category[$column];
                }
            }
            if ($tmp){
                $tagsWithNeedColumns[] = $tmp;
            }
        }

        die(json_encode($tagsWithNeedColumns));
    }

    protected function saveToLog($e){
        logger('error with ' . __METHOD__ . ' '
            . implode(' | ', [
                $e->getMessage(), $e->getLine(), $e->getCode(), $e->getFile()
            ])
        );
    }
}
