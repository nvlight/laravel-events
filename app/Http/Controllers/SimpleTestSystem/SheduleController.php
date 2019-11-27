<?php

namespace App\Http\Controllers\SimpleTestSystem;

use App\Debug;
use App\Models\SimpleTestSystem\Question;
use App\Models\SimpleTestSystem\SelectedQsts;
use App\Models\SimpleTestSystem\Shedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Http\Controllers\SimpleTestSystem\SelectedQstsController;

class SheduleController extends Controller
{

    /**
     * @param string $table_name
     * @return array
     */
    public function getLastInsertNumber($table_name='shedules'){

        // надо сначала найти максимальный number и +1 от него
        $number = 0; $errors = [];
        try {
            $rs = \DB::table($table_name)
                ->select(\DB::raw('MAX(number) as number'))
                //->groupBy('number')
                ->get();
            //dd($rs);
            $number = $rs->first()->number;
            $number++;
            //dd($number);
        }catch (\Exception $e){
            $errors[] = $e->getCode() . $e->getMessage();
        }
        //dd($number);

        $result = ['success' => 1, 'number' => $number];
        if (count($errors))
            $result = ['success' => 0, 'errors' => $errors ];

        return $result;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    //
    public static function createTree($array, $level=0)
    {
        $a = [];
        foreach($array as $v)
        {
            if($level == $v['theme_id'])
            {
                // нужно найти потомков с типом вопрос.
                $child_question_count = 0;
                foreach($array as $kk => $vv)
                    if ($vv['theme_id'] == $v['id'] && $vv['description_type'] == 1)
                        $child_question_count++;

                $tmp_child = [
                    'id' => $v['id'],
                    'theme_id' => $v['theme_id'],
                    'description' => $v['description'],
                    'description_type' => $v['description_type'],
                    'number' => $v['number'],
                    'parent_id' => $v['parent_id'],
                    'type' => $v['type'],
                    'child_question_count' => $child_question_count,
                ];

                $child = self::createTree($array, $v['id']);
                if(!empty($child)){
                    //$a[$v['description']] = $child;

                    //$tmp_child['child_question_count'] = $child_question_count;
                    $tmp_child['child'] = $child;
                    $a[$v['id']] = $tmp_child;
                } else{
                    $a[$v['id']] = $tmp_child;
                }

            }
        }
        return $a;
    }

    /**
     * @param array $array
     * @param int $level
     * @param int $indent
     * @param array $output_array
     * @return array
     */
    public function getQstsWithChildQstsCount(array $array, int $level=0, int $indent=0, array &$output_array){

        $current = [];
        foreach($array as $k => $v)
        {
            if ($v['theme_id'] == $level)
            {
                if ($v['description_type'] === 7)
                {
                    $indent_html = str_repeat("&mdash;", $indent);

                    $cqt = $v['child_question_count'];

                    $tmp = [
                        'id' => $v['id'],
                        'theme_id' => $v['theme_id'],
                        'indent_html' => $indent_html,
                        'description' => $v['description'],
                        'qst_count' => $cqt,
                        'indent' => $indent,
                    ];

                    $output_array[] = $tmp;
                    $indent++;

                    if (array_key_exists('child', $v)){
                        $curr_function = __FUNCTION__;
                        $tmp['child'] = $this->$curr_function($v['child'], $v['id'], $indent, $output_array);
                        if (!count($tmp['child'])){
                            unset($tmp['child']);
                        }
                    }
                    $indent--;


                    $current[] = $tmp;

                }
            }
        }
        return $current;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dump('Hellloooo!');
        //dump($request->all());

        // 1. проверка входных данных
        $validator = Validator::make($request->all(), [
            'test_id' => 'required|int|min:1',
            'selected_qst_name' => 'required|string|min:3',
            'selected_qst_duration' => 'required|int|min:1|max:720',
            'selected_qst_test_started_at' => 'required|date_format:d.m.Y',
            // 'qst_theme_id_.*' => 'required|int|min:1', - это не работает, позже надо создать свой валидатор!
            // https://laravel.com/docs/6.x/validation#after-validation-hook
        ]);
        $errors = [];
        if ($validator->fails()){
            $errors[] = $validator->errors()->toArray();
            //dd($errors);
        }
        if (count($errors)){
            $validateShuduleAndSelectedQsts = ['success' => 0, 'message' => $errors[0]];
            //dd($validateShuduleAndSelectedQsts);
            //dd($errors);
            session()->flash('addNewSelectedQsts', $validateShuduleAndSelectedQsts);
            return back();
        }

        // 1.2 получить все ключи с '^qst_theme_id_'
        // существует ли хотя 1 хороший ключ?
        $all_keys = $request->all(); $need_keys = [];
        foreach($all_keys as $key => $val){
            if (preg_match("#^(qst_theme_id_\d+)#u", $key, $getThere)){
                //echo Debug::d($getThere);
                $tmp = [];
                $tmp['key'] = $getThere[0];
                $tmp['val'] = $request->get($tmp['key']);
                //echo Debug::d($tmp);
                $need_keys[$tmp['key']] = $tmp['val'];
            }
        }
        //dump($need_keys);
        if (!count($need_keys)){
            $tarr = []; $tarr['qst_theme_ids'] = ['Не выбрано ни 1 темы с вопросами'];
            $errors = ['success' => 0, 'message' => $tarr, ];
            //dd($errors);
            session()->flash('addNewSelectedQsts', $errors);
            return back();
        }
        // 1.3 хотя бы 1 тема должна быть с вопросами >= 1
        $exists_one_with_positive_qst_count = false;
        foreach($need_keys as $k => $v)
            if (preg_match('#^[1-9]\d*$#u', $v, $ret)){
                $exists_one_with_positive_qst_count = true; break;
            }
        if (!$exists_one_with_positive_qst_count){
            $tarr = []; $tarr['qst_theme_ids'] = ['Нужно выбрать вопросы в хотя бы одной теме'];
            $errors = ['success' => 0, 'message' => $tarr, ];
            //dd($errors);
            session()->flash('addNewSelectedQsts', $errors);
            return back();
        }
        // 1.4 Самая важная часть, нужно отсеять из массива $need_keys - qst_theme_id_* те, которые существуют
        $qstsWithChildQstsCount = Question::where('parent_id','=',$request->get('test_id'))
            ->whereIn('description_type', [1,7])
            ->get();
        if (!$qstsWithChildQstsCount){
            $errors = ['success' => 0, 'message' => [ 'Questions in TZ' => ['Нет вопросов и тем в текущем ТЗ' ], ] ];
            //dd($errors);
            session()->flash('addNewSelectedQsts', $errors);
            return back();
        }
        //dump($qstsWithChildQstsCount);
        //dump($qstsWithChildQstsCount->toArray());
        $qstsWithChildQsts = [];
        $createTree = self::createTree($qstsWithChildQstsCount->toArray());
        //dump($createTree);
        $this->getQstsWithChildQstsCount($createTree, 0,0, $qstsWithChildQsts);
        //dump($qstsWithChildQsts);
        // наконец-такие получили искомый массив с темами и дочерним кол-во вопросов в них, осталось теперь сопоставить
        // их с данными из формы.
        $we_find_one_good_theme_with_positive_question = false;
        $themesWithCheckedQuestionsCount = [];
        foreach($need_keys as $nk => $nv){

            foreach($qstsWithChildQsts as $qk => $qv){

                $id = str_replace('qst_theme_id_','',$nk);
                // если id совпадают и количество каждого из них больше 0, т.е. можно выбрать вопрос из темы, то
                if ( intval($id) === $qv['id'] && intval($nv) > 0 && intval($nv) && $qv['qst_count'] > 0 ){
                    $we_find_one_good_theme_with_positive_question = true;
                    $themesWithCheckedQuestionsCount[] = [
                        'id' => $qv['id'],
                        'theme_id' => $qv['theme_id'],
                        'qst_count' => intval($nv) > $qv['qst_count'] ? $qv['qst_count'] : intval($nv),
                    ];
                }

            }
        }
        //dump('okk');
        //dump($themesWithCheckedQuestionsCount);
        if (!$we_find_one_good_theme_with_positive_question){
            $errors = ['success' => 0, //'message' => 'Полученный список тем с вопросами не существует в БД!',
                    'message' => [ 'Check themes in DB' => ['Полученный список тем с вопросами не существует в БД!' ], ]
                ];
            //dd($errors);
            session()->flash('addNewSelectedQsts', $errors);
            //dd($errors);
            return back();
        }
        //dd('stop');
        // 2.0 поиск последнего вставленного ИД
        $lastInsertNumber = $this->getLastInsertNumber('selected_qsts');
        //dump($lastInsertNumber);
        if ($lastInsertNumber['success'] !== 1){
            $errors = ['success' => 0, //'message' => 'Не удалось получить последний вставленный ID',
                'message' => [ 'LastInsertNumber' => ['Не удалось получить последний вставленный ID'], ]
            ];
            //dd($errors);
            session()->flash('addNewSelectedQsts', $errors);
            return back();
        }
        $number = $lastInsertNumber['number'];

        // 3. запуск транзакции
        // 3.1 добавление данных в selected_qsts
        // 3.2 добавление данных в shedules
        try{
            \DB::transaction(function () use($themesWithCheckedQuestionsCount, $request, $number) {
                $qsts_count = 0;
                // 2. подготовка данных для вставки в selected_qsts
                foreach($themesWithCheckedQuestionsCount as $qk => $qv) {
                    $selectedQsts = new SelectedQsts();
                    // number, test_id, theme_id, qsts_count
                    $selectedQsts->test_id = $request->get('test_id');
                    $test_id = $selectedQsts->test_id;
                    $selectedQsts->number = $number;
                    $selectedQsts->theme_id = $qv['theme_id'];
                    $selectedQsts->qsts_count = $qv['qst_count'];
                    $qsts_count += $selectedQsts->qsts_count;
                    $selectedQsts->theme_parent_id = $qv['id'];
                    //dump($selectedQsts);
                    $selectedQsts->save();
                }

                // 2.1 подготовка данных для вставка в shedules_qsts
                $shedule = new Shedule();
                $shedule->name = $request->get('selected_qst_name');
                $shedule->test_started_at = Carbon::parse($request->get('selected_qst_test_started_at'))->format('Y-m-d');
                $shedule->duration = $request->get('selected_qst_duration');
                $shedule->selected_qsts_number = $number;
                $shedule->qsts_count = $qsts_count;
                $shedule->test_id = $test_id;
                $shedule->save();

            });
        }catch (\Exception $e){
            $errors = ['success' => 0, 'message' => 'Ошибка при добавлении данных выборки в БД',
                'error' => $e->getCode() . ' || ' . $e->getMessage()
            ];
            //dd($errors);
            session()->flash('addNewSelectedQsts', $errors);
            return back();
        }

        //dd('ok');

        session()->flash('addNewSelectedQsts', ['success' => 1, 'message' => 'Выборка сохранена!']);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SimpleTestSystem\Shedule  $shedule
     * @return \Illuminate\Http\Response
     */
    public function show(Shedule $shedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SimpleTestSystem\Shedule  $shedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Shedule $shedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SimpleTestSystem\Shedule  $shedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shedule $shedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SimpleTestSystem\Shedule  $shedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shedule $sts_shedule)
    {
        //return $sts_shedule;
        // т.к. нужно удалить записи с Shedule и Selected_qsts, нужно запустить транзакцию
        $idsForDeleteOnSelectedQsts = Shedule::where('shedules.id','=',$sts_shedule->id)
            ->join('selected_qsts','selected_qsts.number', '=', 'shedules.selected_qsts_number')
            ->select('selected_qsts.id')
            ->get()->toArray();

        //$idsForDelete = array_merge($idsForDeleteOnSelectedQsts, [ ['id' => $sts_shedule->id]] );
        $idsForDeleteOnSelectedQstsReal = [];
        foreach($idsForDeleteOnSelectedQsts as $k => $v){
            $idsForDeleteOnSelectedQstsReal[] = $v['id'];
        }
        //return $idsForDeleteOnSelectedQstsReal;

        $result = ['success' => 1, 'message' => 'Элемент удален из расписания'];
        try{
            \DB::transaction(function () use($idsForDeleteOnSelectedQstsReal, $sts_shedule) {
                SelectedQsts::whereIn('id', $idsForDeleteOnSelectedQstsReal)->delete();
                Shedule::where('id','=',$sts_shedule->id)->delete();
            });
        }catch (\Exception $e){
            $result = ['success' => 0, 'message' => 'Ошибка при удалении элемента расписания',
                'error' => $e->getCode() . ' || ' . $e->getMessage()];
        }
        session()->flash('deleteElementFromShedulesWithSelectedQstsChilds', $result);
        return back();
    }
}
