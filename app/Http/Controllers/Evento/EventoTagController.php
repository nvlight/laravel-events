<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\EventoTagRequest;
use App\Models\Evento\Evento;
use App\Models\Evento\EventoTag;
use App\Models\Evento\Tag;
use App\Http\Controllers\Controller;

class EventoTagController extends Controller
{
    public function index()
    {
        // не можем получить нужны поля, поэтому вариант не подходит
        //$eventos = auth()->user()->eventos()->pluck('id');
        //$tags = auth()->user()->eventoTags()->pluck('id');
        //$eventotags = EventoTag::whereIn('evento_id',$eventos)
        //    ->whereIn('tag_id',$tags)
        //    ->get();

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

        // - нужно предусмотреть случай с дублированием Тега для Evento

        EventoTag::create($attributes);

        return back();
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

        $eventotag->update($attributes);

        return back();
    }

    public function destroy(EventoTag $eventotag)
    {
        abort_if(auth()->user()->cannot('delete', $eventotag), 403);

        $eventotag->delete();

        return back();
    }
}
