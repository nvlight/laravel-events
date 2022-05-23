<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\EventoRequest;
use App\Models\Evento\Evento;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class EventoController extends Controller
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

    private function getEventoTree(Collection $eventos)
    {
        $eventosWithAllColumnsArray = $eventos->toArray();

        //dump($eventosWithAllColumnsArray);
        //self::d($eventosWithAllColumnsArray,2);

        $eventosWithAllColumnsArrayFormatted = [];
        foreach($eventosWithAllColumnsArray as $j => $v)
        {
            $eventoId = $v['evento_id'];
            $eventosWithAllColumnsArrayFormatted[$eventoId]['evento'] = $v;

            //$eventosWithAllColumnsArrayFormatted[$v['evento_id']][$v['evento_evento_category_id']][] = $v;

            $categories = [];
            $tags = [];
            $attachments = [];
            foreach($eventosWithAllColumnsArray as $l => $g){
                if ($g['evento_id'] === $eventoId && $g['evento_category_id']){
                    $categories[$g['evento_evento_category_id']] = $g;
                }
                if ($g['evento_id'] === $eventoId && $g['evento_tag_id']){
                    $tags[$g['evento_evento_tag_id']] = $g;
                }
                if ($g['evento_id'] === $eventoId && $g['evento_attachment_id']){
                    $attachments[$g['evento_attachment_id']] = $g;
                }
            }

            $eventosWithAllColumnsArrayFormatted[$eventoId]['categories']  = $categories;
            $eventosWithAllColumnsArrayFormatted[$eventoId]['tags']        = $tags;
            $eventosWithAllColumnsArrayFormatted[$eventoId]['attachments'] = $attachments;

            //self::d($attachments,2,1);
            //dd(array_unique($attachments)); die;
            //self::d(array_unique($attachments),2);

        }

        //dd($eventosWithAllColumnsArrayFormatted);
        //self::d($eventosWithAllColumnsArrayFormatted,2);

        return $eventosWithAllColumnsArrayFormatted;
    }

    protected function getEventoTreeById($eventoId){
        $eventosWithAllColumns = Evento::
        leftJoin('evento_evento_categories','evento_evento_categories.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_categories','evento_categories.id','=','evento_evento_categories.category_id')
            ->leftJoin('evento_evento_tags','evento_evento_tags.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_tags','evento_tags.id','=','evento_evento_tags.tag_id')
            ->leftJoin('evento_evento_tag_values','evento_evento_tag_values.evento_evento_tags_id','=','evento_evento_tags.id')
            ->leftJoin('evento_attachments','evento_attachments.evento_id','=','evento_eventos.id')
            ->where('evento_eventos.user_id','=',auth()->id())
            //->where('evento_categories.user_id','=',auth()->id())
            //->where('evento_tags.user_id','=',auth()->id())
            ->where('evento_eventos.id', $eventoId)
            ->select('evento_eventos.id as evento_id', 'evento_eventos.description as evento_description', 'evento_eventos.date as evento_date', 'evento_eventos.date as date',
                'evento_categories.id as evento_category_id', 'evento_categories.name as evento_category_name',
                'evento_evento_categories.id as evento_evento_category_id',
                'evento_tags.id as evento_tag_id', 'evento_tags.name as evento_tag_name', 'evento_tags.color as evento_tag_color',
                'evento_evento_tags.id as evento_evento_tag_id',
                'evento_evento_tag_values.id as evento_evento_tag_values_id',
                'evento_evento_tag_values.value as evento_evento_tag_value_value',
                'evento_evento_tag_values.caption as evento_evento_tag_value_caption',
                'evento_attachments.id as evento_attachment_id',
                'evento_attachments.originalname as evento_attachment_originalname',
                'evento_attachments.size as evento_attachment_size'
            )
            ->orderBy('evento_eventos.date', 'desc')
            //->limit(1)
        ;
        //dd($eventosWithAllColumns);

        return $this->getEventoTree($eventosWithAllColumns->get());
    }

    protected function getEventoHtml($evento){
        return View::make('cabinet.evento._inner.list.item', ['evento' => $evento ])->render();
    }

    protected function mainQuery(){

        $eventosWithAllColumns = Evento::
        leftJoin('evento_evento_categories','evento_evento_categories.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_categories','evento_categories.id','=','evento_evento_categories.category_id')
            ->leftJoin('evento_evento_tags','evento_evento_tags.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_tags','evento_tags.id','=','evento_evento_tags.tag_id')
            ->leftJoin('evento_evento_tag_values','evento_evento_tag_values.evento_evento_tags_id','=','evento_evento_tags.id')
            ->leftJoin('evento_attachments','evento_attachments.evento_id','=','evento_eventos.id')
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
                'evento_evento_tag_values.caption as evento_evento_tag_value_caption',
                'evento_attachments.id as evento_attachment_id',
                'evento_attachments.originalname as evento_attachment_originalname',
                'evento_attachments.size as evento_attachment_size'
            )
            ->orderBy('evento_eventos.date', 'desc')
            //->toSql()
        ;

        return $eventosWithAllColumns;
    }

    public function index(Request $request)
    {
        $eventosWithAllColumns = $this->mainQuery();
        //dd($eventosWithAllColumns);

        $eventosTree = $this->getEventoTree($eventosWithAllColumns->get());
        $eventoCount = count($eventosTree);

        $perPage = env('EVENTO_PER_PAGE', 15);
        $currentPage = $request->input('page');
        $currentPage = $currentPage == null ? 1 : $currentPage;
        $offset = $currentPage == 1 ? 0 : $currentPage * $perPage - $perPage;

        $eventos = array_slice($eventosTree, $offset, $perPage);

        $paginator = new LengthAwarePaginator(
            $eventos, count($eventosTree), $perPage, $currentPage,
            ['path' => 'evento', 'pageName' => 'page']
        );

        return view('cabinet.evento.index', compact('eventos', 'paginator', 'eventoCount') );
    }

    public function create()
    {
        return view('cabinet.evento.create');
    }

    public function store(EventoRequest $request)
    {
        $attributes = $request->validated();
        $attributes += ['user_id' => auth()->id()];

        try{
            $evento = Evento::create($attributes);
            session()->flash('crud_message',['message' => 'Evento created!', 'class' => 'alert alert-success']);
        }catch (\Exception $e){
            $this->saveToLog($e);
            return back()->with('crud_message',['message' => 'Evento create failed!', 'class' => 'alert alert-success']);
        }

        return redirect()->route('cabinet.evento.edit', $evento);
    }

    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => ['required', 'string', 'max:155', 'min:3'],
            'date' => ['required', 'date'],
        ]);

        if ($validator->fails()){
            $rs = ['success' => 0, 'message' => 'Ошибки валидации!', 'errors' => $validator->errors()->toArray(),
                'data' => $request->all()
            ];
            die(json_encode($rs));
        }

        $attributes = $request->all();
        $attributes += ['user_id' => auth()->id()];

        try{
            $evento = Evento::create($attributes);
            session()->flash('crud_message',['message' => 'Evento created!', 'class' => 'alert alert-success']);

            // теперь нужно получить строку с этим Evento, т.е. верстку с данными.
            $eventoTree = $this->getEventoTreeById($evento->id);
            $eventoHtml = ""; $eventoId = 0;
            if(count($eventoTree)){
                $eventoId   = $eventoTree[array_keys($eventoTree)[0]];
                // eventoRowHtml
                $eventoHtml = $this->getEventoHtml($eventoId);
            }
            $rs = ['success' => 1, 'message' => 'Evento created!',
                'eventoHtml' => $eventoHtml, 'eventoId' => $eventoId['evento']['evento_id']];
        }catch (\Exception $e){
            $this->saveToLog($e);
            $rs = ['success' => 1, 'message' => 'Evento create failed!'];
        }

        die(json_encode($rs));
    }

    public function show(Evento $evento)
    {
        abort_if(auth()->user()->cannot('view', $evento), 403);

        return view('cabinet.evento.show', compact('evento'));
    }

    public function getAjax(int $eventoId)
    {
        try{
            $evento = Evento::find($eventoId);
            $rs = ['success' => 1, 'message' => 'Evento finded!'];
        }catch (\Exception $e){
            $this->saveToLog($e);
            $rs = ['success' => 0, 'message' => 'Evento not finded!'];
        }

        if (auth()->user()->cannot('view', $evento)){
            $rs = ['success' => 0, 'message' => 'Access denied!'];
        }

        try{
            $htmlEventoTable = View::make('cabinet.evento._inner.get_evento_table', compact('evento'))->render();
            $htmlEventoEditDeleteButtons = View::make('cabinet.evento._inner.get_evento_edit_delete_new_buttons',
                compact('evento'))->render();
            $tableClass = "table table-bordered table-striped";

            $rs['eventoTableClass'] = $tableClass;
            $rs['htmlEventoTable'] = $htmlEventoTable;
            $rs['htmlEventoEditDeleteButtons'] = $htmlEventoEditDeleteButtons;
        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'Error with make views!'];
            $this->saveToLog($e);
        }

        die(json_encode($rs));
    }

    public function edit(Evento $evento)
    {
        abort_if(auth()->user()->cannot('update', $evento), 403);

        return view('cabinet.evento.edit', compact('evento'));
    }

    public function editAjax(int $eventoId)
    {
        try{
            $evento = Evento::find($eventoId);
            $rs = ['success' => 1, 'message' => 'Evento finded!'];
        }catch (\Exception $e){
            $this->saveToLog($e);
            $rs = ['success' => 0, 'message' => 'Evento not finded!'];
        }

        if (auth()->user()->cannot('view', $evento)){
            $rs = ['success' => 0, 'message' => 'Access denied!'];
        }

        try{
            $eventoEditTable = View::make('cabinet.evento._inner.edit_evento_modal_inner', compact('evento'))->render();
            $action = route('cabinet.evento.update', $evento);
            $method = 'post';
            $enctype = 'multipart/form-data';

            $rs['eventoEditTable'] = $eventoEditTable;
            $rs['action'] = $action;
            $rs['method'] = $method;
            $rs['enctype'] = $enctype;
        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'Error with make views!'];
            $this->saveToLog($e);
        }

        die(json_encode($rs));
    }

    public function update(EventoRequest $request, Evento $evento)
    {
        abort_if(auth()->user()->cannot('update', $evento), 403);

        $attributes = $request->validated();
        $attributes['date'] = (new Carbon($attributes['date']))->format('Y-m-d');

        try{
            $evento->update($attributes);
            session()->flash('crud_message',['message' => 'Evento updated!', 'class' => 'alert alert-success']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return back();
    }

    public function updateAjax(Request $request, $eventoId)
    {
        try{
            $evento = Evento::find($eventoId);
        }catch (\Exception $e){
            $this->saveToLog($e);
            $rs = ['success' => 0, 'message' => 'Evento not finded!'];
            die(json_encode($rs));
        }

        if (auth()->user()->cannot('update', $evento)){
            $rs = ['success' => 0, 'message' => 'Access denied!'];
            die(json_encode($rs));
        }

        // validate this
        $validator = Validator::make($request->all(), [
            'description' => ['required', 'string', 'max:155', 'min:3'],
            'date' => ['required', 'date'],
        ]);
        if ($validator->fails()){
            $rs = ['success' => 0, 'message' => 'Ошибки валидации!', 'errors' => $validator->errors()->toArray(),
                'data' => $request->all(), 'description' => $evento->description, 'date' => $evento->date
            ];
            die(json_encode($rs));
        }

        //sleep(3);
        try{
            $attributes = $request->all();

            $attributes['date'] = (new Carbon($attributes['date']))->format('Y-m-d');
            $evento->update($attributes);

            // теперь нужно обновить строку.
            $eventoTree = $this->getEventoTreeById($evento->id);
            $eventoHtml = ""; $eventoId = 0;
            if(count($eventoTree)){
                $eventoId   = $eventoTree[array_keys($eventoTree)[0]];
                $eventoHtml = $this->getEventoHtml($eventoId);
            }
            $rs = ['success' => 1, 'message' => 'Сохранено!',
                'eventoHtml' => $eventoHtml, 'eventoId' => $eventoId['evento']['evento_id']];

        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'Error with update evento!'];
            $rs['eventoId'] = $evento->id;
            $this->saveToLog($e);
        }

        die(json_encode($rs));
    }

    public function destroy(Evento $evento)
    {
        abort_if(auth()->user()->cannot('delete', $evento), 403);

        try{
            $evento->delete();
            session()->flash('crud_message',['message' => 'Evento deleted!', 'class' => 'alert alert-danger']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return redirect()->route('cabinet.evento.index');
    }

    public function destroyAjax(Evento $evento)
    {
        abort_if(auth()->user()->cannot('delete', $evento), 403);

        try{
            $eventoId = $evento->id;
            $evento->delete();

            $rs = ['success' => 1, 'message' => 'Evento deleted!', 'eventoId' => $eventoId];
        }catch (\Exception $e){
            $this->saveToLog($e);
            $rs = ['success' => 0, 'message' => 'Evento delete failed!'];
        }

        die(json_encode($rs));
    }

    protected function saveToLog($e){
        logger('error with ' . __METHOD__ . ' '
            . implode(' | ', [
                $e->getMessage(), $e->getLine(), $e->getCode(), $e->getFile()
            ])
        );
    }
}