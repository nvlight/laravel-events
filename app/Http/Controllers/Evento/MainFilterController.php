<?php

namespace App\Http\Controllers\Evento;

use App\Models\Evento\Evento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Evento\Tag;
use App\Models\Evento\Category;
use Illuminate\Support\Facades\DB;

class MainFilterController extends Controller
{
    const MIN_AMOUNT = 0;
    const MAX_AMOUNT = 300000;
    const DESCRIPTION_MIN_LENGTH = 3;

    protected function saveToLog($e){
        logger('error with ' . __METHOD__ . ' '
            . implode(' | ', [
                $e->getMessage(), $e->getLine(), $e->getCode(), $e->getFile()
            ])
        );
    }

    protected function dieJsonEncode($value){
        die(json_encode($value));
    }

    protected function getTagsRs(){
        $result = ['success' => 0];
        try{
            $query = Tag::where('user_id', auth()->id())->orderBy('created_at', 'DESC');
            $rs = $query->get()->toArray();
            $result = ['success' => 1, 'rs' => $rs, 'rss' => $query->get() ];
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return $result;
    }

    protected function getCategoriesRs(){
        $result = ['success' => 0];
        try{
            $query = Category::where('user_id', auth()->id())->orderBy('created_at', 'DESC');
            $rs = $query->get()->toArray();
            $result = ['success' => 1, 'rs' => $rs, 'rss' => $query->get() ];
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return $result;
    }

    public function getTags(){

        $tags = $this->getTagsRs();
        //dump($tags);

        $this->dieJsonEncode($tags);
    }

    public function getCategories(){

        $categories = $this->getCategoriesRs();
        //dump($categories);

        $this->dieJsonEncode($categories);
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

    public function mainQuery($startDate, $endData, $startAmount, $endAmount, $description)
    {
        // todo validate request

        $queryPart = Evento::
              leftJoin('evento_evento_tags','evento_evento_tags.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_tags','evento_tags.id','=','evento_evento_tags.tag_id')
            ->leftJoin('evento_evento_categories','evento_evento_categories.evento_id','=','evento_eventos.id')
            ->leftJoin('evento_categories','evento_categories.id','=','evento_evento_categories.category_id')

            // todo это join нужно сделать опциональным, чтобы можно было искать без значений тегов
            ->join('evento_evento_tag_values','evento_evento_tag_values.evento_evento_tags_id','=','evento_evento_tags.id')

            ->where('evento_eventos.user_id', auth()->id())
            ->where('evento_eventos.date', '>=', $startDate)
            ->where('evento_eventos.date', '<=', $endData)

            // todo - дополнительное условие к join-у сверху
            ->where('evento_evento_tag_values.value', '>=', $startAmount)
            ->where('evento_evento_tag_values.value', '<=', $endAmount)

            ->select(
                'evento_eventos.description', 'evento_eventos.date',
                'evento_tags.*',
                'evento_categories.*'
            );

        // for tags
        $tagsFilterIds = [];
        if (request()->get('all_tags')){
            $allTags = $this->getTagsRs();
            if ($allTags['success']){
                $tagsFilterIds =  $allTags['rss']->pluck('id')->toArray();
            }
        }else{
            if (request()->get('tag_ids')) {
                $tagsFilterIds = request()->get('tag_ids');
            }
        }
        $queryPart = $queryPart->whereIn('evento_tags.id', $tagsFilterIds);

        // for categories
        $categoryFilterIds = [];
        if (request()->get('all_categories')){
            $allCategories = $this->getCategoriesRs();
            if ($allCategories['success']){
                $categoryFilterIds = $allCategories['rss']->pluck('id')->toArray();
            }
        }else{
            if (request()->get('category_ids')){
                $categoryFilterIds = request()->get('category_ids');
            }
        }
        $queryPart = $queryPart->whereIn('evento_categories.id', $categoryFilterIds);

        // description filter
        if ($description && strlen($description) >= self::DESCRIPTION_MIN_LENGTH ){
            $queryPart = $queryPart->where('evento_eventos.description', 'like', '%' . $description . '%');
        }

        // last part for OrderBy
        $queryPart = $queryPart->orderBy('evento_eventos.date');

        // cool debug
        //$tempRs = ['rs' => \Str::replaceArray('?', $queryPart->getBindings(), $queryPart->toSql())];
        //die(json_encode($tempRs));

        $queryPart = $queryPart->get();

        $queryResult = $queryPart->toArray();

        return $queryResult;
    }

    protected function filterHandle(){

        $requestData = request()->all();

        // todo - create new validation
        $startDate = request()->get('date1') ?? date('Y-m-d');
        $endDate =   request()->get('date2') ?? date('Y-m-d');
        $startAmount = request()->get('amount1') ?? self::MIN_AMOUNT;
        $endAmount   = request()->get('amount2') ?? self::MAX_AMOUNT;
        $description = request()->get('description') ?? '';

        $filteredData = $this->mainQuery($startDate, $endDate, $startAmount, $endAmount, $description);

        $result = ['success' => 1, 'message' => 'dummy filter',
            'resultDataCount' => count($filteredData),
            'data1' => $startDate,
            'data2' => $endDate,
            'requestData' => $requestData, 'resultData' => $filteredData,
        ];

        return $result;
    }

    public function filter(){

        $filter = $this->filterHandle();

        $this->dieJsonEncode($filter);
    }
}
