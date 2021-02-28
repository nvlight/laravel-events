<?php

namespace App\Http\Controllers\Evento;

use App\Models\Evento\Evento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class EventoTagCountingDiagram extends Controller
{
    static public function d($value, $type=1, $die=1){
        echo "<pre>";
        if (intval($type)===1){
            var_dump($value);
        }else{
            print_r($value);
        }
        echo "</pre>";

        if ($die){
            die;
        }
    }

    protected function getCurrentYear()
    {
        $year = \request()->exists('year');
        if ($year){
            $year = \request('year');
            if (!preg_match("#^[0-9]{4}$#u",$year))
                $year = Date('Y');
        }else{
            $year = Date('Y');
        }

        return $year;
    }

    public function getData()
    {
        $pie = $this->getPieData();
        //self::d($eventoTagResult, 2);

        return view('cabinet.evento.eventotagcounting.pie_diagram', ['eventoTagResult' => $pie]);
    }

    public function getPieData()
    {
        $year = $this->getCurrentYear();

        $eventoTagQuery = Evento::
        leftJoin('evento_evento_categories','evento_evento_categories.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_categories','evento_categories.id','=','evento_evento_categories.category_id')
            ->leftJoin('evento_evento_tags','evento_evento_tags.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_tags','evento_tags.id','=','evento_evento_tags.tag_id')
            ->join('evento_evento_tag_values','evento_evento_tag_values.evento_evento_tags_id','=','evento_evento_tags.id')
            ->where('evento_eventos.user_id', auth()->id())
            ->where(DB::raw('year(evento_eventos.date)'), $year)
            ->select(
                'evento_tags.name as tag_name',
                'evento_tags.color as tag_color',
                DB::raw('SUM(evento_evento_tag_values.value) as tag_value')
            )
            ->groupby('tag_name', 'tag_color')
        ;
        $eventoTagResult = $eventoTagQuery->get()->toArray();

        return $eventoTagResult;
    }

    public function getPieDataRender($pie){
        return View::make('cabinet.evento.eventotagcounting.pie_diagram_ajax', ['eventoTagResult' => $pie])->render();
    }

    public function getPieAjax(){
        $year = $this->getCurrentYear();

        $pie = $this->getPieData();
        $rendered = $this->getPieDataRender($pie);
        $rs = ['success' => 1, 'message' => 'its all fine!', 'current_year' => $year, 'rendered' => $rendered];

        die(json_encode($rs));
    }
}
