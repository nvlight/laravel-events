<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\EventoTagValueRequest;
use App\Models\Evento\EventoTagValue;
use App\Http\Controllers\Controller;
use App\Models\Evento\Tag;

class EventoTagValueController extends Controller
{
    public function index()
    {
        $eventoTagValues = Tag::
              leftJoin('evento_evento_tags','evento_evento_tags.tag_id','=','evento_tags.id')
            ->leftJoin('evento_eventos','evento_eventos.id','=','evento_evento_tags.evento_id')
            ->join('evento_evento_tag_values','evento_evento_tag_values.evento_evento_tags_id','=','evento_evento_tags.id')
            ->where('evento_eventos.user_id','=',auth()->id())
            ->select('evento_eventos.id as evento_id', 'evento_eventos.description as evento_description', 'evento_eventos.date as evento_date',
                'evento_evento_tags.tag_id', 'evento_tags.name as tag_name',
                'evento_evento_tags.id as evento_evento_tag_id',
                'evento_evento_tag_values.id as evento_evento_tag_values_id',
                'evento_evento_tag_values.value as evento_evento_tag_value_value',
                'evento_evento_tag_values.caption as evento_evento_tag_value_caption'
            )
            ->get();

        return view('cabinet.evento.eventotagvalue.index', compact('eventoTagValues'));
    }

    public function create()
    {
        $eventoTags = Tag::
              leftJoin('evento_evento_tags','evento_evento_tags.tag_id','=','evento_tags.id')
            ->leftJoin('evento_eventos','evento_eventos.id','=','evento_evento_tags.evento_id')
            ->where('evento_eventos.user_id','=',auth()->id())
            ->select('evento_eventos.id as evento_id', 'evento_eventos.description as evento_description', 'evento_eventos.date as evento_date',
                'evento_evento_tags.tag_id', 'evento_tags.name as tag_name',
                'evento_evento_tags.id as evento_evento_tag_id'
            )
            ->get();

        return view('cabinet.evento.eventotagvalue.create', compact('eventoTags'));
    }

    public function store(EventoTagValueRequest $request)
    {
        $attributes = $request->validated();

        EventoTagValue::create($attributes);

        return back();
    }

    public function show(EventoTagValue $eventoTagValue)
    {
        return view('cabinet.evento.eventotagvalue.show', compact('eventoTagValue'));
    }

    public function edit(EventoTagValue $eventoTagValue)
    {
        $eventoTags = Tag::
              leftJoin('evento_evento_tags','evento_evento_tags.tag_id','=','evento_tags.id')
            ->leftJoin('evento_eventos','evento_eventos.id','=','evento_evento_tags.evento_id')
            ->join('evento_evento_tag_values','evento_evento_tag_values.evento_evento_tags_id','=','evento_evento_tags.id')
            ->where('evento_eventos.user_id','=',auth()->id())
            ->where('evento_evento_tag_values.id','=',$eventoTagValue->id)
            ->select('evento_eventos.id as evento_id', 'evento_eventos.description as evento_description', 'evento_eventos.date as evento_date',
                'evento_evento_tags.tag_id', 'evento_tags.name as tag_name',
                'evento_evento_tags.id as evento_evento_tag_id',
                'evento_evento_tag_values.id as evento_evento_tag_values_id',
                'evento_evento_tag_values.value as evento_evento_tag_value_value',
                'evento_evento_tag_values.caption as evento_evento_tag_value_caption'
            )
            ->get();

        return view('cabinet.evento.eventotagvalue.edit', compact('eventoTags'));
    }

    public function update(EventoTagValueRequest $request, EventoTagValue $eventoTagValue)
    {
        $attributes = $request->validated();

        $attributes['evento_evento_tags_id'] = $eventoTagValue->evento_evento_tags_id;

        $eventoTagValue->update($attributes);

        return back();
    }

    public function destroy(EventoTagValue $eventoTagValue)
    {
        $eventoTagValue->delete();

        return back();
    }
}
