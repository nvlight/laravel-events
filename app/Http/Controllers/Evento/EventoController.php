<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\EventoRequest;
use App\Models\Evento\Evento;
use App\Http\Controllers\Controller;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = auth()->user()->eventos;

        $eventosWithAllColumns = Evento::
              leftJoin('evento_evento_categories','evento_evento_categories.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_categories','evento_categories.id','=','evento_evento_categories.category_id')
            ->leftJoin('evento_evento_tags','evento_evento_tags.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_tags','evento_tags.id','=','evento_evento_tags.tag_id')
            ->leftJoin('evento_evento_tag_values','evento_evento_tag_values.evento_evento_tags_id','=','evento_evento_tags.id')
            ->where('evento_eventos.user_id','=',auth()->id())
            ->where('evento_categories.user_id','=',auth()->id())
            ->where('evento_tags.user_id','=',auth()->id())
            ->select('evento_eventos.id as evento_id', 'evento_eventos.description as evento_description', 'evento_eventos.date as evento_date',
                'evento_categories.id as evento_category_id', 'evento_categories.name as evento_category_name',
                'evento_evento_categories.id as evento_evento_category_id',
                'evento_tags.id as evento_tag_id', 'evento_tags.name as evento_tag_name', 'evento_tags.color as evento_tag_color',
                'evento_evento_tags.id as evento_evento_tag_id',
                'evento_evento_tag_values.id as evento_evento_tag_values_id',
                'evento_evento_tag_values.value as evento_evento_tag_value_value',
                'evento_evento_tag_values.caption as evento_evento_tag_value_caption'
            )
            ->orderBy('evento_eventos.date')
            ->get();

        return view('cabinet.evento.index', compact('eventos','eventosWithAllColumns'));
    }

    public function create()
    {
        return view('cabinet.evento.create');
    }

    public function store(EventoRequest $request)
    {
        $attributes = $request->validated();

        $attributes += ['user_id' => auth()->id()];

        Evento::create($attributes);

        return back();
    }

    public function show(Evento $evento)
    {
        abort_if(auth()->user()->cannot('view', $evento), 403);

        return view('cabinet.evento.show', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        abort_if(auth()->user()->cannot('update', $evento), 403);

        return view('cabinet.evento.edit', compact('evento'));
    }

    public function update(EventoRequest $request, Evento $evento)
    {
        abort_if(auth()->user()->cannot('update', $evento), 403);

        $attributes = $request->validated();

        $evento->update($attributes);

        return back();
    }

    public function destroy(Evento $evento)
    {
        abort_if(auth()->user()->cannot('delete', $evento), 403);

        $evento->delete();

        return back();
    }
}