<?php

namespace App\Http\Controllers\SimpleTestSystem;

use App\Debug;
use App\Models\SimpleTestSystem\Question;
use App\Models\SimpleTestSystem\SavedSelectedQst;
use App\Models\SimpleTestSystem\SelectedQsts;
use App\Models\SimpleTestSystem\Shedule;
use App\Models\SimpleTestSystem\Test;
use App\Models\SimpleTestSystem\TestCategory;
use App\models\simpleTestSystem\TestResult;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class HhController extends Controller
{
    public function index(){

        $testCatsWithChildTests = TestCategory::
            join('tests', 'tests.parent_id','=','test_categories.id')
            ->select('test_categories.name as category', 'tests.*');

        $sql = $testCatsWithChildTests->toSql();
        //dump($sql);
        $testCatsWithChildTestsGet = $testCatsWithChildTests
            ->get()
            ->toArray();

        $testCatsWithChildTests = TestCategory::
          join('tests', 'tests.parent_id','=','test_categories.id')
            ->join('shedules', 'shedules.test_id', '=', 'tests.id')
            ->select('test_categories.id as category_id',
                'test_categories.name as category',
	            'tests.NAME AS test',
	            'tests.id as test_id',
                'shedules.id as shedule_id',
                'shedules.name AS selection_name',
	            'shedules.duration AS selection_duration',
	            'shedules.selected_qsts_number AS selected_qsts_number',
	            'shedules.qsts_count'
            )
            ->groupBy('category_id', 'category', 'test', 'test_id',
                'selection_name', 'selection_duration', 'selected_qsts_number', 'qsts_count', 'shedule_id')
            ->orderBy('shedules.id', 'DESC')
        ;

        $sql = $testCatsWithChildTests->toSql();
        //dump($sql);
        $testCatsWithChildTestsGet = $testCatsWithChildTests
            ->get()
            ->toArray();
        //echo Debug::d($testCatsWithChildTestsGet);
        //dd($testCatsWithChildTests);
        $testCatsWithChildTestsGetFormatted = [];
        foreach($testCatsWithChildTestsGet as $k => $v){
            $testCatsWithChildTestsGetFormatted[$v['category_id']][$v['test_id']][] = $v;
        }
        //dump($testCatsWithChildTestsGetFormatted);

        return view('st_start.index', compact('testCatsWithChildTests',
            'testCatsWithChildTestsGetFormatted'
        ));
    }

    /**
     * @param Shedule $shedule_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showThemes(Shedule $shedule_id){
        //return $shedule_id;
        //dump($shedule_id->toArray());
        $theme_ids = SelectedQsts::where('selected_qsts.number', '=', $shedule_id['selected_qsts_number'])
            ->join('questions', 'selected_qsts.theme_parent_id', '=', 'questions.id')
            //->join('tests','tests.id','=','selected_qsts.test_id')
            ->where('description_type','=',7)
            //->distinct()
            ->select('description','theme_parent_id') //,'tests.name as tests_name'
            ->get()
            ->toArray()
        ;
        //dump($theme_ids);

        $testBreadCrumbs = Test::where('tests.id','=', $shedule_id->test_id)
            ->join('test_categories','test_categories.id','=','tests.parent_id')
            ->select('test_categories.name as category', 'tests.name as test_name')
            ->get()
            //->toArray()
        ;
        //dump($testBreadCrumbs->first());
        //dd($testBreadCrumbs);
        // {{$testBreadCrumbs->category}}/{{$testBreadCrumbs->test_name}}

        return view('st_start.themes', compact('theme_ids', 'shedule_id', 'testBreadCrumbs'));
    }

    /**
     * @param Collection $collection
     * @param string $key
     * @return array
     */
    public function getCollectionColumnByKey(Collection $collection, string $key):array{
        $a = [];

        foreach($collection as $value){
            $a[] = $value->$key;
        }

        return $a;
    }

    /**
     * @param array $qsts
     * @param int $id
     * @return mixed|null
     */
    public function getQstCategoryNameById(array $qsts, int $id){
        $result = null;

        foreach($qsts as $qst){
            if ($qst['qst_id'] === $id){
                $result = $qst['description'];
                break;
            }
        }

        return $result;
    }

    /**
     * @param array $qsts
     * @param int $id
     * @return mixed|null
     */
    public function getQstsParentArray(array $qsts, int $id){
        $result = null;

        foreach($qsts as $qst){
            if ($qst['qst_id'] === $id){
                $result = $qst;
                break;
            }
        }

        return $result;
    }

    /**
     * @param array $qsts
     * @param array $cats
     * @return array
     */
    public function getQuestionsWithCategory(array $qsts, array $cats):array{

        foreach($qsts as &$qst){
            $qst['category'] = $this->getQstCategoryNameById($cats, $qst['theme_id']);
            //$qst['parent'] = $this->getQstsParentArray($cats, $qst['theme_id']);
        }

        return $qsts;
    }

    /**
     * @param array $qstThemes
     * @param array $qsts
     * @return array
     */
    public function getThemeChildQstsNumbersByParentQstId(array $qstThemes, array $qsts):array{

        foreach($qstThemes as &$qstTheme){

            $numbers = [];
            foreach($qsts as $qst){

                if ($qstTheme['qst_id'] === $qst['theme_id']){
                    $numbers[$qst['number']] = 'h';
                }
                $qstTheme['qsts_numbers'] = array_keys($numbers);
            }

        }

        return $qstThemes;
    }

    /**
     * @param array $qsts
     * @param int $seconds
     * @return array
     */
    public function getThemeChildQstsNumbersByParentQstIdWithRandomNumbers(array $qsts, int $seconds = 10000000):array{

        foreach($qsts as &$qst){
            srand((float) microtime() * $seconds);
            $input = array("Neo", "Morpheus", "Trinity", "Cypher", "Tank");
            $rand_keys = array_rand($qst['qsts_numbers'], $qst['qsts_count']);

            if ($qst['qsts_count'] !== 1){
                $qst['qsts_random_numbers'] = $rand_keys;
            }else{
                $qst['qsts_random_numbers'] = [$rand_keys];
            }
        }

        return $qsts;
    }

    /**
     * @param array $themes
     * @param array $qsts
     * @return array
     */
    public function getThemesWithChildRandomQsts(array $themes, array $qsts): array{

        foreach($themes as &$theme){

            foreach($theme['qsts_random_numbers'] as $k => $v){
                $child = [];

                foreach($qsts as $qst){
                    //echo Debug::d($qst);
                    if ($qst['number'] === $theme['qsts_numbers'][$v]){
                        $child[] = $qst;
                    }
                }

                $theme['child'][] = $child;
            }

        }

        return $themes;
    }

    /**
     * @param $shedule_id
     * @return mixed
     */
    public function getTestingIds($shedule_id){

        // получение test_categories.name/tests.name/shedules.name
        $getNames = Shedule::where('shedules.id','=',$shedule_id)
            ->join('tests','tests.id','=','shedules.test_id')
            ->join('test_categories','test_categories.id','=','tests.parent_id')
            ->select('test_categories.name as category','tests.name as test_name','shedules.name as selection',
                'test_categories.id as category_id', 'tests.id as test_id' ,'shedules.id as shedule_id',
                'shedules.selected_qsts_number as selected_qsts_id'
            )
            ->get()
            ->toArray()
        ;
        return $getNames;
    }

    //
    public function testStart(){

        $started_config_key = config('services.sts.test_start_session_key');

        // получение $_POST['shedules_id']
        $shedule_id = intval(request()->post('shedules_id'));
        //$shedule_id = 10;
        //dd($shedule_id);

        $getNames = $this->getTestingIds($shedule_id);
        //dump($getNames);
        //dd($getNames);
        //echo Debug::d($getNames);
        if (!count($getNames)){
            die('wrong shedule_id!');
        }

        // добавить проверку на существование shedule_id, category_id, test_id
        // эти 3 параметра нужно занести в сессию
        $test_start_key = config('services.sts.test_start_session_key');
        if (session()->has($test_start_key)){
            //echo Debug::d(session()->all()); die('');
            //session()->forget($test_start_key);
            return redirect('/tests/resume');
        }

        $test_start = [
            'shedule_id' => $getNames[0]['shedule_id'],
            'category_id' => $getNames[0]['category_id'],
            'test_id' => $getNames[0]['test_id'],
            'selected_qsts_id' => $getNames[0]['selected_qsts_id'],
        ];
        session()->put($test_start_key, $test_start);

        // получение theme_ids
        $theme_ids_sql = Shedule::where('shedules.id','=',$shedule_id)
            ->join('selected_qsts','selected_qsts.number','=','shedules.selected_qsts_number')
            ->join('questions','questions.id','=','selected_qsts.theme_parent_id')
            ->select('questions.id as qst_id','questions.number','questions.description','selected_qsts.qsts_count',
                'questions.description_type','selected_qsts.test_id', 'selected_qsts.id as selected_qsts_id'
            );

        $qstsThemes = $theme_ids_sql // $qstsThemes
            ->get()
            //->toArray()
        ;
        // theme_array with all keys
        //dump($qstsThemes->toArray());
        //echo Debug::d($qstsThemes->toArray());

        $theme_ids = $this->getCollectionColumnByKey($qstsThemes, 'qst_id');
        //dump($theme_ids);

        //dump($qstsThemes->first()->test_id);
        // получение всех ids, у которых theme_id in $theme_ids
        $qstsChildsByThemeId = Question::where('parent_id','=',$qstsThemes->first()->test_id)
            ->whereIn('theme_id', $theme_ids)
            //->select(DB::raw("distinct(number)"))
            ->get()
            ->toArray()
        ;
        //dump($qstsChildsByThemeId);
        //echo Debug::d($qstsChildsByThemeId,'',1);

        // получение ids дочерних вопросов
        $themeChildQstsNumbersByParentQstId = $this->getThemeChildQstsNumbersByParentQstId($qstsThemes->toArray(), $qstsChildsByThemeId);
        //echo Debug::d($themeChildQstsNumbersByParentQstId);

        // получение случайных id по qsts_count
        $themeChildQstsNumbersByParentQstIdWithRandomNumbers = $this->getThemeChildQstsNumbersByParentQstIdWithRandomNumbers($themeChildQstsNumbersByParentQstId);
        //echo Debug::d($themeChildQstsNumbersByParentQstIdWithRandomNumbers);

        // получение вопросов дочерних вопросов к каждой теме.
        $themesWithChildRandomQsts = $this->getThemesWithChildRandomQsts($themeChildQstsNumbersByParentQstIdWithRandomNumbers, $qstsChildsByThemeId);
        //echo Debug::d($themesWithChildRandomQsts,'',1);

        //echo \App\Debug::d(request()->all());
        //echo Debug::d($getNames);
        //die;

        $lastTestNumber = $this->getLastTestNumber();
        //echo Debug::d($lastTestNumber,'$lastTestNumber');
        if (!$lastTestNumber['success']) {
            echo Debug::d('getLastTestNumber - error!');
            die;
        }


        $result = ['success' => 1, 'transaction is done'];
        try{
            \DB::transaction(function () use($lastTestNumber, $test_start, $themesWithChildRandomQsts) {

                $testResult = new TestResult();
                $testResult->test_number = $lastTestNumber['number'];
                //$testResult->saved_selected_qsts_id = 0; //
                $testResult->selected_qsts_id = $test_start['selected_qsts_id'];
                $testResult->test_id = $test_start['test_id'];
                $testResult->shedule_id = $test_start['shedule_id'];
                $testResult->test_status = 1;
                //$testResult->ball = 0;
                //$testResult->test_started_at = 0;
                //$testResult->test_ended_at = 0;
                $testResult->save();

                $qsts_numbers = [];
                foreach($themesWithChildRandomQsts as $k => $v){
                    if (isset($v['child'])){
                        foreach($v['child'] as $kk => $vv){
                            $qsts_numbers[] = $vv[0]['number'];
                        }
                    }
                }
                foreach($qsts_numbers as $qk => $qv){
                    $ssq = new SavedSelectedQst();
                    $ssq->test_number = $lastTestNumber['number'];
                    $ssq->selected_qsts_id = $test_start['selected_qsts_id'];
                    $ssq->test_id = $test_start['test_id'];
                    $ssq->shedule_id = $test_start['shedule_id'];
                    $ssq->qsts_number = $qv;
                    $ssq->save();
                }

            });
            $new_session = session()->get($test_start_key);
            $new_session['test_number'] = $lastTestNumber['number'];
            session()->put($test_start_key, $new_session);

            //echo Debug::d(session()->get($test_start_key));
            //echo Debug::d($new_session);
            //echo Debug::d(session()->get($test_start_key));
            //die;

        }catch (\Exception $e){
            $result = ['success' => 0, 'message' => 'transaction is failed', 'error' => $e->getCode() . ' || ' . $e->getMessage()];
        }

        if (!$result['success']){
            echo Debug::d($result); die;
        }

        return view('st_start.test_start', compact('themesWithChildRandomQsts',
                'getNames', 'started_config_key')
        );
    }

    //
    public function getLastTestNumber(){

        // надо сначала найти максимальный number и +1 от него
        $number = 0; $errors = [];
        try {
            $rs = \DB::table('test_results')
                //->select('*')
                ->select(\DB::raw('MAX(test_number) as number'))
                ->get();
            $number = $rs->first()->number;
            $number++;
        }catch (\Exception $e){
            $errors[] = $e->getCode() . $e->getMessage();
        }

        $result = ['success' => 1, 'number' => $number];
        if (count($errors))
            $result = ['success' => 0, 'errors' => $errors ];

        return $result;
    }

    //
    public function destroyUserSession(){

        $started_config_key = config('services.sts.test_start_session_key');
        if (session()->has($started_config_key)){
            session()->forget($started_config_key);
            return redirect('/tests/');
        }
    }

    //
    public function addCategoriesToQsts(array $qstsAll, array $qsts){

        // теперь нужно пройтись еще раз по списку и добавить к элементам титл родительской темы.
        foreach($qsts as $k => &$v){

            foreach($v as $kk => &$vv){

                foreach($qstsAll as $kkk => $vvv){
                    if ($vv['theme_id'] === $vvv['id']){
                        $vv['category'] = $vvv['description'];
                        break;
                    }
                }
            }

        }
        return $qsts;
    }

    //
    public function testResume(){

        //$this->destroyUserSession();
        //echo Debug::d(session()->all()); die;

        $started_config_key = config('services.sts.test_start_session_key');
        if (!session()->has($started_config_key)){
            return redirect('/tests');
        }

        //echo Debug::d('Да, это снова мы, нужно сохрнаненное отобразить тут же!');

        //echo Debug::d(session()->get($started_config_key));

        // получение номеров вопросов
        $qstsNew = TestResult::where('test_results.test_number','=',session()->get($started_config_key)['test_number'])
            ->join('saved_selected_qsts','saved_selected_qsts.test_number','=','test_results.test_number')
            ->select('saved_selected_qsts.qsts_number')
            ->get()->toArray();
        //echo Debug::d($qstsNew,'$qstsNew');
        if (!$qstsNew || !count($qstsNew)){
            die('$qstsNew!');
        }

        // получаю из questions все элементы с test_id = parent_id = моему = (session()->get($started_config_key)['test_id']
        $qsts_all = Question::where('parent_id','=', (session()->get($started_config_key)['test_id']))
            ->get()->toArray();
        //echo Debug::d($qsts_all);
        $qstsWithAllColumnsAndRows = [];
        foreach($qstsNew as $k => $v){

            $tmp = [];
            foreach($qsts_all as $kk => $vv){
                if ($v['qsts_number'] === $vv['number']){
                    $tmp[] = $vv;
                }
            }
            if (count($tmp))
                $qstsWithAllColumnsAndRows[] = $tmp;
        }
        //echo Debug::d($qstsWithAllColumnsAndRows);
        $qstsWithAllColumnsAndRowsAndCategoryTitles = $this->addCategoriesToQsts($qsts_all, $qstsWithAllColumnsAndRows);
        //echo Debug::d($qstsWithAllColumnsAndRowsAndCategoryTitles,'titlesss');

        // получение test_categories.name/tests.name/shedules.name
        $getNames = $this->getTestingIds(session()->get($started_config_key)['shedule_id']);
        //echo Debug::d($getNames);

        /* вопросы с названием категории получены в виде 1 массива
         *
         * [0] => Array (
         *      [0] => Array
         *          (
         *              [id] => 101
         *              [parent_id] => 11
         *              [theme_id] => 85
         *              [number] => 13
         *              [type] => 1
         *              [description] => Какой оператор используется для разделения инструкций в PHP?
         *              [description_type] => 1
         *              [status] => 1
         *              [created_at] => 2019-11-19 12:20:23
         *              [updated_at] => 2019-11-19 12:20:23
         *              [category] => Основы синтаксиса
         *          )
         *
         * теперь нужно получить массив вида
         * [0] => array(
         *      [description] => Основы языка
         *      [childs] =>
         *              [0] => array(
         *                  [0] => array(
         *                          [id] => 101
         *                          [parent_id] => 11
         *                          [theme_id] => 85
         *                          [number] => 13
         *                          [type] => 1
         *                          [description] => Какой оператор используется для разделения инструкций в PHP?
         *                          [description_type] => 1
         *                          [status] => 1
         *                      }
         *                  [1] => array{
         *
         *                  }
         * для этого сначала получу категории, потом пройдусь по категориям и сформирую childs, это все нужно для того,
         * чтобы не пришлось переписывать представление, выводящее вопросы!
         *
         **/
        $QuestionsCategories = [];
        foreach($qstsWithAllColumnsAndRowsAndCategoryTitles as $k => $v){
            foreach($v as $kk => $vv)
            $QuestionsCategories[$vv['category']] = '';
        }
        //echo Debug::d($QuestionsCategories,'$QuestionsCategories'); //die;
        $newQuestionsWithChilds = [];
        foreach(array_keys($QuestionsCategories) as $k => $v){

            $tmp = [];
            foreach($qstsWithAllColumnsAndRowsAndCategoryTitles as $kk => $vv){
                foreach($vv as $kkk => $vvv){
                    if ($vvv['category'] === $v){
                        $tmp[] = $vv;
                        break;
                    }
                }
            }
            if (count($tmp)) {
                $newQuestionsWithChilds[] = [
                    'description' => $v,
                    'child' => $tmp
                ];
            }
        }
        //echo Debug::d($newQuestionsWithChilds,'$newQuestionsWithChilds');


        $themesWithChildRandomQsts = $newQuestionsWithChilds;
        //die;

        return view('st_start.test_start', compact('themesWithChildRandomQsts',
            'getNames', 'started_config_key')
        );
    }

    //
    public function testResults(Request $request){

        $started_config_key = config('services.sts.test_start_session_key');

        if (!session()->has($started_config_key)){
            return redirect('/tests/');
        }

        echo Debug::d($request->all());
        session()->forget($started_config_key);

    }

    //
    public function saveResult(){

        // test_number	29 in {saved_selected_qsts; test_results}
        // params	id_16_118 (16 questions.number;  118 = answered questions.id)
        // checked	true {пришедший овет, если чекбокс может быть false/true, если radio - только true}

        $rs = ['success' => 1, 'message' => 'its all ok for now!'];

        $test_number = \request()->get('test_number');
        $checked = true;
        $intPattern = "#^[1-9]\d*$#";
        $params = explode('_', \request()->get('params'));
        if (
            !(  count($params) == 3
                && preg_match($intPattern, $params[1])
                && preg_match($intPattern, $params[2])
            )
        ) {
            $rs = ['success' => 0, 'message' => 'params is bad!'];
            die($rs);
        }
        $question_number = $params[1];
        $question_id = $params[2];

        // #1 валидация на существование данных параметров

        // #2 по questions.number узнать тип вопроса (1,2)
        $question_type = 1; // xD

        // #3 исходя из 2 подсунуть нужный сохранение
        switch ($question_type){
            case 1:
                $rs = ['success' => 1, 'message' => 'okey!',
                    'question_type' => $question_type,
                    'question_number' => $question_number,
                    'question_id' => $question_id
                ];
                try{
                    $ssq = SavedSelectedQst::where('test_number','=',$test_number)
                        ->where('qsts_number','=',$question_number)
                        //->get()
                    ;
                    //die($ssq);
                    //$ssq->qsts_answer = $question_id;
                    $ssq->update(['qsts_answer' => $question_id]);
                    //$ssq->save();
                    $rs = ['success' => 1, 'message' => 'saved!'];
                }catch (\Exception $e){
                    $rs = ['success' => 0, 'message' => $e->getLine() . '_' . $e->getFile() . '_' . $e->getMessage()];
                    break;
                }
                break;
            default:
                $rs = ['success' => 0, 'message' => 'undefined question_type!'];
        }

        die(json_encode($rs));

    }


}