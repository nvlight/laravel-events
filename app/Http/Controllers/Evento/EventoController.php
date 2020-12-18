<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\EventoRequest;
use App\Models\Evento\Evento;
use App\Http\Controllers\Controller;
use App\Models\MGDebug;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EventoController extends Controller
{
    /**/
    private function getEventoTree(Collection $eventos)
    {
        $eventosWithAllColumnsArray = $eventos->toArray();

        //dump($eventosWithAllColumnsArray);

        $eventosWithAllColumnsArrayFormatted = [];
        foreach($eventosWithAllColumnsArray as $j => $v)
        {
            $eventoId = $v['evento_id'];
            $eventosWithAllColumnsArrayFormatted[$eventoId]['evento'] = $v;

            //$eventosWithAllColumnsArrayFormatted[$v['evento_id']][$v['evento_evento_category_id']][] = $v;

            $categories = [];
            foreach($eventosWithAllColumnsArray as $l => $g){
                if ($g['evento_id'] === $eventoId && $g['evento_category_id']){
                    $categories[$g['evento_evento_category_id']] = $g;
                }
            }

            $tags = [];
            foreach($eventosWithAllColumnsArray as $l => $g){
                if ($g['evento_id'] === $eventoId && $g['evento_tag_id']){
                    $tags[$g['evento_evento_tag_id']] = $g;
                }
            }

            $eventosWithAllColumnsArrayFormatted[$eventoId]['categories'] = $categories;
            $eventosWithAllColumnsArrayFormatted[$eventoId]['tags']       = $tags;
        }

        //echo "<pre>";
        //(print_r($eventosWithAllColumnsArrayFormatted));
        //echo "</pre>";
        //dd($eventosWithAllColumnsArrayFormatted);
        return $eventosWithAllColumnsArrayFormatted;
    }

    public function index(Request $request)
    {
        //Evento::all()->dd();
        //$eventos = auth()->user()->eventos;

        $eventosWithAllColumns = Evento::
              leftJoin('evento_evento_categories','evento_evento_categories.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_categories','evento_categories.id','=','evento_evento_categories.category_id')
            ->leftJoin('evento_evento_tags','evento_evento_tags.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_tags','evento_tags.id','=','evento_evento_tags.tag_id')
            ->leftJoin('evento_evento_tag_values','evento_evento_tag_values.evento_evento_tags_id','=','evento_evento_tags.id')
            ->where('evento_eventos.user_id','=',auth()->id())
            //->where('evento_categories.user_id','=',auth()->id())
            //->where('evento_tags.user_id','=',auth()->id())
            ->select('evento_eventos.id as evento_id', 'evento_eventos.description as evento_description', 'evento_eventos.date as evento_date', 'evento_eventos.date as date',
                'evento_categories.id as evento_category_id', 'evento_categories.name as evento_category_name',
                'evento_evento_categories.id as evento_evento_category_id',
                'evento_tags.id as evento_tag_id', 'evento_tags.name as evento_tag_name', 'evento_tags.color as evento_tag_color',
                'evento_evento_tags.id as evento_evento_tag_id',
                'evento_evento_tag_values.id as evento_evento_tag_values_id',
                'evento_evento_tag_values.value as evento_evento_tag_value_value',
                'evento_evento_tag_values.caption as evento_evento_tag_value_caption'
            )
            ->orderBy('evento_eventos.date');

        $eventosTree = $this->getEventoTree($eventosWithAllColumns->get());

        $perPage = 5;
        $currentPage = $request->input('page');
        $currentPage = $currentPage == null ? 1 : $currentPage;
        $offset = $currentPage == 1 ? 0 : $currentPage * $perPage - $perPage;

        $eventos = array_slice($eventosTree, $offset, $perPage);

        $paginator = new LengthAwarePaginator(
            $eventos, count($eventosTree), $perPage, $currentPage,
            ['path' => 'evento', 'pageName' => 'page']
        );

        return view('cabinet.evento.index',
            compact('eventos', 'paginator'));
    }

    public function create()
    {
        return view('cabinet.evento.create');
    }

    public function store(EventoRequest $request)
    {
        $attributes = $request->validated();

        $attributes += ['user_id' => auth()->id()];

        $evento = Evento::create($attributes);

        session()->flash('created', 'sucess created');

        return redirect()->route('cabinet.evento.edit', $evento);
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
        $attributes['date'] = (new Carbon($attributes['date']))->format('Y-m-d');

        $evento->update($attributes);

        session()->flash('saved', 'sucess updated');

        return back();
    }

    public function destroy(Evento $evento)
    {
        abort_if(auth()->user()->cannot('delete', $evento), 403);

        $evento->delete();

        session()->flash('deleted', 'sucess deleted');

        return redirect()->route('cabinet.evento.index');
    }
}