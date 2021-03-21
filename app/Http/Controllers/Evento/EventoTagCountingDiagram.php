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

    protected function getYears()
    {
        $q = Evento::
                leftJoin('evento_evento_tags','evento_evento_tags.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_tags','evento_tags.id','=','evento_evento_tags.tag_id')
            ->join('evento_evento_tag_values','evento_evento_tag_values.evento_evento_tags_id','=','evento_evento_tags.id')
            ->where('evento_eventos.user_id', auth()->id())
            ->select(
                DB::raw( 'distinct(year(evento_eventos.date)) as date')
            )
            ->orderBy('date')
        ;
        $rs = $q->get()->toArray();

        return $rs;
    }

    public function getPieData($currentYear=null)
    {
        $year = $currentYear ?? $this->getCurrentYear();

        $eventoTagQuery = Evento::
            leftJoin('evento_evento_tags','evento_evento_tags.evento_id','=','evento_eventos.id')
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
        $rs = ['success' => 1, 'message' => 'pie data is geted!!', 'current_year' => $year, 'pie' => $pie,
            'years' => $this->getYears(),
        ];

        die(json_encode($rs));
    }

    public function getPieAjaxByYear($year=null){
        $currentYear = $year ?? $this->getCurrentYear();

        $pie = $this->getPieData($currentYear);
        $rs = ['success' => 1, 'message' => 'pie data is geted!!', 'pie' => $pie, 'years' => $this->getYears(),
            'current_year' => $currentYear,];

        die(json_encode($rs));
    }

    protected function getGistogrammDataByYear($year=null){
        $year = $currentYear ?? $this->getCurrentYear();

        $query = Evento::
            leftJoin('evento_evento_tags','evento_evento_tags.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_tags','evento_tags.id','=','evento_evento_tags.tag_id')
            ->join('evento_evento_tag_values','evento_evento_tag_values.evento_evento_tags_id','=','evento_evento_tags.id')
            ->where('evento_eventos.user_id', auth()->id())
            ->where(DB::raw('year(evento_eventos.date)'), $year)
            ->select(
                'evento_eventos.date',
                DB::raw('MONTHNAME(evento_eventos.date) as month'),
                'evento_tags.name as tag_name',
                'evento_tags.color as tag_color',
                'evento_evento_tag_values.value as tag_value'
            )
            ->orderBy('evento_eventos.date')
        ;

        $result = $query->get()->toArray();

        return $result;
    }

    protected function restructureGistogrammData($data){
        $res = [];

        foreach($data as $k => $v){
            if (! isset($res[$v['month']][$v['tag_name']]) ) {
                $res[$v['month']][$v['tag_name']] = [
                    'tag_color' => $v['tag_color'],
                    'tag_value' => $v['tag_value'],
                ];
            }else{
                $res[$v['month']][$v['tag_name']] = [
                    'tag_color' => $v['tag_color'],
                    'tag_value' => $res[$v['month']][$v['tag_name']]['tag_value'] += $v['tag_value'],
                ];
            }
        }

        return $res;
    }

    public function getGistogrammDataHandler(){

        $data = $this->getGistogrammDataByYear();
        $restruct = $this->restructureGistogrammData($data);

        //$this->d($data,2);
        //$this->d($restruct,2);

        return $restruct;
    }

    public function getGistogrammDataByYearAjax($year=null){
        $currentYear = $year ?? $this->getCurrentYear();

        $gistogramm = $this->getGistogrammDataHandler($currentYear);
        $rs = [
            'success' => 1,
            'message' => 'gistogramm is geted!',
            'gistogramm' => $gistogramm,
            'years' => $this->getYears(),
            'current_year' => $currentYear,
        ];

        die(json_encode($rs));
    }
}
