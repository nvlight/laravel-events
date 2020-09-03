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

        return view('cabinet.evento.index', compact('eventos'));
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