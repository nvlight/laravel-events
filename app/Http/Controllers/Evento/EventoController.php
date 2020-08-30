<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\EventoRequest;
use App\Models\Evento\Evento;
use App\Http\Controllers\Controller;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();

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
        return view('cabinet.evento.show', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        return view('cabinet.evento.edit', compact('evento'));
    }

    public function update(EventoRequest $request, Evento $evento)
    {
        $attributes = $request->validated();

        $evento->update($attributes);

        return back();
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();

        return back();
    }
}