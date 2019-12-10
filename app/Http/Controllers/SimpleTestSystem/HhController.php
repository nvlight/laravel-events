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
use Carbon\Carbon;
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

                // прямо тут можно перемешать вопрос!
                $questionShuffled = $child;
                $questionShuffled = $this->shuffleQuestionSingle($child);

                $theme['child'][] = $questionShuffled; //$child;
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
                'shedules.selected_qsts_number as selected_qsts_id', 'shedules.duration as duration'
                //'shedules.test_number as test_number'
            )
            ->get()
            ->toArray()
        ;
        return $getNames;
    }

    /**
     * Перемешивание вопросов входного массива
     * @param array $questions
     * @return array
     */
    public function questionsShuffle(array $questions):array{

        $questions_tmp = [];

        foreach($questions as $qk => $qv){
            $tmp = $this->shuffleQuestionChilds($qv);
            $questions_tmp[] = $tmp;
        }

        return $questions_tmp;
    }

    /**
     * Получение одногомерно массива вопросов, создание из него 2-мерного по номеру вопроса и перемешивание вопросов
     * @param array $questions
     * @return array
     */
    public function questionsGroupedByNumberAndShuffle(array $questions):array{

        $questions_tmp = $this->questionsGroupedByNumber($questions);
        $questions_tmp = $this->questionsShuffle($questions_tmp);
        $questions_tmp = $this->questionsTwoDimensionalArrayConvertToOneDimensioinal($questions_tmp);
        $questionsCategoriesArray = $this->questionsAddCategoriesItemsToArray($questions);
        $questions_tmp = array_merge($questions_tmp, $questionsCategoriesArray);

        return $questions_tmp;
    }

    /**
     * Получения из одноверного массива с вопросами двумерного, ключами которого являются номера вопросов
     * @param array $questions
     * @return array
     */
    public function questionsGroupedByNumber(array $questions):array{

        $groupedQuestions = [];

        foreach($questions as $k => $v){
            if ($v['type'] > 0){
                $groupedQuestions[$v['number']][] = $v;
            }
        }

        return $groupedQuestions;
    }

    /**
     * Добавление в массив элементов типа 'вопросы', которые изначально были из нее удалены
     * @param array $questions
     * @return array
     */
    public function questionsAddCategoriesItemsToArray(array $questions):array{

        $questions_arr = [];

        foreach($questions as $qk => $qv){
            if ($qv['type'] === 0){
                $questions_arr[] = $qv;
            }
        }

        return $questions_arr;
    }

    /**
     * Преобразование двумерного массива с ключом номера вопроса в одномерный
     * @param array $questions
     * @return array
     */
    public function questionsTwoDimensionalArrayConvertToOneDimensioinal(array $questions):array{

        $questions_tmp = [];

        foreach($questions as $qk => $qv){
            foreach($qv as $qkk => $qvv){
                $questions_tmp[] = $qvv;
            }
        }

        return $questions_tmp;
    }

    /**
     * TEST START --->
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
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
            'test_name' => $getNames[0]['test_name'],
            'selected_qsts_id' => $getNames[0]['selected_qsts_id'],
            'duration' => $getNames[0]['duration'],
            'category' => $getNames[0]['category'],
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

        $timeDiff = $this->getTimeDiff();

        if (!$result['success']){
            echo Debug::d($result); die;
        }

        $savedQuestionsQnswersByTestNumber = ['data' => []];

        return view('st_start.test_start', compact('themesWithChildRandomQsts',
                'getNames', 'started_config_key', 'timeDiff', 'savedQuestionsQnswersByTestNumber')
        );
    }

    /**
     * TEST RESUME --->
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function testResume(){

        //$this->destroyUserSession(); return redirect('/tests');
        //echo Debug::d(session()->all()); die;

        $started_config_key = config('services.sts.test_start_session_key');
        if (!session()->has($started_config_key)){
            return redirect('/tests');
        }

        // если время истекло, то сразу выходим!
        $timeDiff = $this->getTimeDiff();
        if ($timeDiff['success']){

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
            $this->destroyUserSession();
            return $this->redirect('/tests');
            //die('$qstsNew!');
        }

        // получаю из questions все элементы с test_id = parent_id = моему = (session()->get($started_config_key)['test_id']
        $qsts_all = Question::where('parent_id','=', (session()->get($started_config_key)['test_id']))
            ->get()->toArray();
        //echo Debug::d($qsts_all); //die;

        // сделаю из $qsts_all массив с номерами вопросов,
        // потом перемешаю ответы вопросов,
        // потом соберу обратно в 1 массив
        $qsts_all = $this->questionsGroupedByNumberAndShuffle($qsts_all);
        //echo Debug::d($qsts_all); die;

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
        //echo Debug::d($qstsWithAllColumnsAndRows); die;
        $qstsWithAllColumnsAndRowsAndCategoryTitles = $this->addCategoriesToQsts($qsts_all, $qstsWithAllColumnsAndRows);
        //echo Debug::d($qstsWithAllColumnsAndRowsAndCategoryTitles,'titlesss');

        // получение test_categories.name/tests.name/shedules.name
        $getNames = $this->getTestingIds(session()->get($started_config_key)['shedule_id']);
        $getNames[count($getNames)-1]['test_number'] = session()->get($started_config_key)['test_number'];
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

        // получу сохраненные ответы на вопросы по номеру теста test_number
        $savedQuestionsQnswersByTestNumber = $this->getQuestionsQnswersByTestNumber($getNames[count($getNames)-1]['test_number']);
        //echo Debug::d($savedQuestionsQnswersByTestNumber,'',2); //die;

        return view('st_start.test_start', compact('themesWithChildRandomQsts',
                'getNames', 'started_config_key', 'timeDiff', 'savedQuestionsQnswersByTestNumber'
            )
        );
    }

    //
    public function testttt(int $a, int $b):float{
        return ($a + $b)/2;
    }

    /**
     * Получение всех ответов на вопросы для введенего номера тестирования.
     * @param int $testNumber
     * @return array
     */
    public function getQuestionsQnswersByTestNumber(int $testNumber):array{

        try{
            $recordSet = SavedSelectedQst::where('test_number','=', $testNumber)
                ->select('qsts_number', 'qsts_answer')
                ->get()->toArray();
            $result = ['success' => 1, 'message' => 'uestionsQnswersByTestNumber is geted now!'];
            $result['data'] = $recordSet;
        }catch (\Exception $e){
            $result = ['success' => 0, 'message' => $e->getCode() . $e->getMessage() ];
        }

        return $result;
    }

    /**
     * Получение последнего номера для таблицы test_results
     * @return array
     */
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

    /**
     * Уничтожение пользовательской сессии и редирект на главную
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * @param int $qid
     * @return array
     */
    public function getQuestionTypeByQuestionNumber(int $qnumber):array{

        try{
            $qst_type = Question::where('number','=',$qnumber)->select('type')->get()->first()->type;
            $result = ['success' => 1, 'message' => 'type is getting', 'result_type_id' => $qst_type];
        }catch (\Exception $e){
            $result = ['success' => 0, 'message' => $e->getLine() . '_' . $e->getFile() . '_' . $e->getMessage()];
        }

        return $result;
    }

    /**
     * @param int $test_id
     * @param int $number
     * @return array
     */
    public function getQuestionByTetsIdAndNumber(int $test_id, int $number):array{

        try{
            $questionChildsByNumber = Question::where('parent_id','=', $test_id)
                ->where('number','=',$number)
                //->where('description_type','=',2)
            ;
            $questionChildsByNumberSQL = $questionChildsByNumber;
            //dump($questionChildsByNumberSQL->toSql());

            $questionChildsByNumber = $questionChildsByNumber
                ->get()->toArray();
            //echo Debug::d($questionChildsByNumber,'chichn');

            $result = ['success' => 0, 'message' => 'im didnt find answer with that id!!!'];
            if (count($questionChildsByNumber))
                $result = ['success' => 1, 'message' => 'thats true question checkbox answers!',
                    'data' => $questionChildsByNumber];

        }catch (\Exception $e){
            $result = ['success' => 0, 'message' => $e->getLine() . '_' . $e->getFile() . '_' . $e->getMessage()];
        }
        return $result;

    }

    /**
     * @param array $qst
     * @return string
     */
    private function getQuestionDescription(array $qst):string{
        $description = "";
        foreach($qst as $item)
            if ($item['description_type'] === 1){
                $description = $item['description'];
                break;
            }
        return $description;
    }

    /** Получение массива, содержащего вопрос из входного массива с вопросом и ответами к нему.
     * @param array $qst
     * @return array
     */
    private function getQuestionDescriptionArray(array $qst):array{

        $result_arr = [];

        foreach($qst as $item)
            if ($item['description_type'] === 1){
                $result_arr = $item;
                break;
            }
        return $result_arr;
    }

    /**
     * @param array $qst
     * @return array
     */
    private function getQuestionAnswers(array $qst):array{
        $a = [];
        foreach($qst as $item)
            if (filter_var($item['description_type'], FILTER_VALIDATE_INT,
                [ 'options' => ['min_range' => 2, 'max_range' => 3] ]) ){
                $a[] = $item;
            }
        return $a;
    }

    /**
     * Перемешивает варианты ответов заданного вопроса
     * @param array $question
     * @return array массив вопроса с перемешанными ответами
     */
    public function shuffleQuestionChilds(array $question):array{

        $questionDescriptionArray = [$this->getQuestionDescriptionArray($question)];
        $questionAnswersChildsArray = $this->getQuestionAnswers($question);

        $shuffleQuestionAnswerChildsArray = $questionAnswersChildsArray;
        shuffle($shuffleQuestionAnswerChildsArray);

        $shuffleQuestion = array_merge($questionDescriptionArray, $shuffleQuestionAnswerChildsArray);

        return $shuffleQuestion;
    }

    /**
     * Перемешивание ответов одного вопроса
     * @param array $question
     * @return array
     */
    public function shuffleQuestionSingle(array $question): array{

        $questionDescriptionArray = $this->getQuestionDescriptionArray($question);
        $questionAnswers = $this->getQuestionAnswers($question);
        $shuffledQuestion = array_merge([count($questionAnswers) => $questionDescriptionArray] + $questionAnswers);
        shuffle($shuffledQuestion);

        return $shuffledQuestion;
    }

    // тестирую получение вопроса по тест_ид и номеру и его перемешивание
    public function test_getQuestionByTetsIdAndNumber(){

        $testId = 11;
        $number = 12;
        $question = $this->getQuestionByTetsIdAndNumber($testId, $number);
        echo Debug::d($question);
        $shuffleQuestion = $this->shuffleQuestionChilds($question['data']);
        echo Debug::d($shuffleQuestion);
    }

    /**
     * @param int $test_id
     * @param int $qst_number
     * @param int $answer_id
     * @return array
     */
    public function isQuestionAnswerTrueForRadio(int $test_id, int $qst_number, int $answer_id):array{

        $questionChildsByNumber = $this->getQuestionByTetsIdAndNumber($test_id, $qst_number);
        if (!$questionChildsByNumber['success']){
            $result = $questionChildsByNumber;
            return $result;
        }

        $find = false;
        foreach($questionChildsByNumber['data'] as $k => $v){
            if ($v['id'] === $answer_id && $v['description_type'] === 2){
                $find = true;
                break;
            }
        }

        $result = ['success' => 0, 'message' => 'im found nothing!'];

        if ($find)
            $result = ['success' => 1, 'message' => 'thats true question radio answer!'];

        return $result;
    }

    /**
     * @param int $test_id
     * @param int $qst_number
     * @param array $answer_id
     * @return array
     */
    public function isQuestionAnswerTrueForCheckbox(int $test_id, int $qst_number, array $answer_ids):array{

        $questionChildsByNumber = $this->getQuestionByTetsIdAndNumber($test_id, $qst_number);
        if (!$questionChildsByNumber['success']){
            $result = $questionChildsByNumber;
            return $result;
        }

        //echo Debug::d($answer_ids,'',1);
        //echo Debug::d($questionChildsByNumber,'',1); die;

//        $find = true;
//        foreach($answer_ids as $ak => $av) {
//
//            $id_exists = false; $needId = 0;
//            foreach($questionChildsByNumber['data'] as $k => $v){
//                if (($v['id'] === $av)) {
//                    $id_exists = true;
//                    $needId = $k;
//                    break;
//                }
//            }
//            if (!$id_exists) {
//                $find = false;
//                break;
//            }
//
//            if ($questionChildsByNumber['data'][$needId]['description_type'] !== 2){
//                $find = false;
//                break;
//            }
//
//        }

        // попробую другим способом, найду все эталонные правильные ответы, и сравню их ИД с моими.
        $etalonTrueIds = [];
        foreach($questionChildsByNumber['data'] as $k => $v){
            if ($v['description_type'] === 2) {
                $etalonTrueIds[] = $v['id'];
            }
        }
        //echo Debug::d($etalonTrueIds,'',2);
        //echo Debug::d($answer_ids,'',2);
        $find = true;
        foreach($etalonTrueIds as $k => $v){
            $curr_find = false;
            foreach($answer_ids as $kk => $vv)
                if ($v === $vv){
                    $curr_find = true;
                }
            if (!$curr_find) {
                $find = false;
                break;
            }
        }


        $result = ['success' => 0, 'message' => 'im found nothing!'];

        if ($find)
            $result = ['success' => 1, 'message' => 'thats true question checkbox answers!'];

        return $result;
    }

    /**
     * @param int $test_id
     * @param int $qst_number
     * @param int $qst_type
     * @param array $answers
     * @return array
     */
    public function isQuestionAnswersTrue(int $test_id, int $qst_number, int $qst_type, array $answers){

        switch ($qst_type){
            case 1:
                $result = $this->isQuestionAnswerTrueForRadio($test_id, $qst_number, $answers[0]);
                break;
            case 2:
                $result = $this->isQuestionAnswerTrueForCheckbox($test_id, $qst_number, $answers);
                break;
            default:
                $result = ['success' => 0, 'message' => 'undefined question type'];
        }

        return $result;
    }

    /**
     * @param array $request
     * @return array
     */
    public function countingResultBallsByRequest($request=[]){

        // полученный запрос имеет вид.
//        [_token] => baPwbzeeKtMZAiheUcMnTLbs4BDFuCkLgoj32yWp
//        [shedule_id] => 12
//        [category_id] => 7
//        [test_id] => 11
//        [selected_qsts_id] => 6
//        [radio_qst_number_12] => Array
//        (
//            [0] => 98
//        )
//        [checkbox_qst_number_24] => Array
//        (
//            [0] => 156
//            [1] => 157
//        )
        // тестовый набор входных данных для быстрого моделирования нужной обработки данных!
//        $rqst_test = [
//            'shedule_id' => 12,
//            'category_id' => 7,
//            'test_id' => 11,
//            'selected_qsts_id' => 6,
//            'radio_qst_number_12' => [
//              0 => 99
//            ],
//            'checkbox_qst_number_24' => [
//                0 => 156,
//                1 => 157
//            ],
//        ];

        $rqst_test = $request;

        // получаем все вопросы по test_id: test_id = questions.parent_id
        $all_qsts = Question::where('parent_id','=',$rqst_test['test_id'])->get()->toArray();
        //echo Debug::d($all_qsts);

        // по selected_qsts_id = 6: shedules -> selected_qsts_number = selected_qsts_id получаем кол-во вопросов и минут
        $questionsCountAndDurationNumber = Shedule::where('id','=',$rqst_test['shedule_id'])
            ->select('duration','qsts_count')->get()->toArray();
        //echo Debug::d($questionsCountAndDurationNumber);


        // написать функцию для определения типа вопроса по ID. exmpl: radio_qst_number_12 -> 12 -> qst_type - 1 open
        // test that
        //echo Debug::d($this->getQuestionTypeByQuestionNumber(24));

        // получим все вопросы типа радио и типа чекбокс а также номер вопроса, тип вопроса и ИД-шники ответов
        $neededQuestionTypeArrayTypes = [
            'radioQuestionsAnwsersIds'    => "#^(radio_qst_number_)([1-9]\d*)#u",
            'checkboxQuestionsAnwsersIds' => "#^(checkbox_qst_number_)([1-9]\d*)#u",
        ];
        try {
            foreach($neededQuestionTypeArrayTypes as $k => $v){

                $$k = [];
                foreach($rqst_test as $kk => $vv){
                    if (preg_match($v, $kk, $matches)){
                        //echo Debug::d($matches);
                        /// ! потом эту функцию нужно заменить без использования запросов к БД, сразу 1 раз возьмем весь ТЗ
                        $qst_type = $this->getQuestionTypeByQuestionNumber($matches[2]);
                        if (!$qst_type['success']) break;
                        //echo Debug::d($qst_type); break;
                        //
                        $qst_type = $qst_type['result_type_id'];
                        $tmp_rs = [ 'number' => $matches[2], 'type' => $qst_type ];
                        switch ($qst_type){
                            case 1:
                                $tmp_rs['answer_ids'] = $rqst_test[$matches[0]];
                                break;
                            case 2:
                                $ids = [];
                                foreach($rqst_test[$matches[0]] as $mk => $mv){
                                    $ids[] = $mv;
                                }
                                $tmp_rs['answer_ids'] = $ids;
                                break;
                        }
                        $$k[] = $tmp_rs;
                    }
                }
            }
        }catch (\Exception $e){
            $result = ['success' => 0, 'message' => $questionsCountAndDurationNumber['message']];
            return $result;
        }
        foreach($neededQuestionTypeArrayTypes as $k => $v){
            //echo Debug::d(${$k});
        }
        //echo Debug::d($this->isQuestionAnswersTrue($rqst_test['test_id'], 12, 1, [99]));
        //echo Debug::d($this->isQuestionAnswersTrue($rqst_test['test_id'], 24, 2, [156,157,158]));

        $trueAnswers = 0;
        foreach($neededQuestionTypeArrayTypes as $k => $v){

            foreach(${$k} as $kk1 => $vv1){
                if ($this->isQuestionAnswersTrue($rqst_test['test_id'], $vv1['number'], $vv1['type'],
                    $vv1['answer_ids'])['success'] === 1 ){
                    $trueAnswers++;
                }
            }

        }
        //echo Debug::d($trueAnswers);

        // emxpl2: [checkbox_qst_number_24] -> 24 -> qst_type - 2 open
        // написать функции (2 штуки), которые из типа и ответа (ненулевого) узнают правильность ответа исходя из
        // типа вопроса и выбранных ответов на вопросов.
        // foreach($questions as $question) - проходимся циклом по всему
        //

        return $result = ['success' => 1, 'balls' => $trueAnswers, 'questionsCountAndDurationNumber' => $questionsCountAndDurationNumber];
        //dump($result);
    }

    //
    public function testResults(Request $request){

        $started_config_key = config('services.sts.test_start_session_key');

        if (!session()->has($started_config_key)){
            return redirect('/tests/');
        }

        //echo Debug::d($started_config_key);
        //echo Debug::d($request->all());
        $result = $this->countingResultBallsByRequest($request->all());
        $sessionInner = session()->get($started_config_key);
        //echo Debug::d($sessionInner);
        $timeDiff = $this->getTimeDiff();
        session()->forget($started_config_key);

        return view('simpletestsystem.test.results', compact('result','sessionInner','timeDiff'));
    }

    /**
     * Сохранение состояния вопроса по test_number, questions.numbger и answered questions.id
     * @return mixed die($json)
     */
    public function saveSingleQuestionResultByClickWithAjax(){

        // test_number	29 in {saved_selected_qsts; test_results}
        // params	id_16_118 (16 questions.number;  118 = answered questions.id)
        // checked	true {пришедший овет, если чекбокс может быть false/true, если radio - только true}

        // если время истекло, нужно отказать в обновлении ответа на вопрос
        if ($this->isTestTimeEnded()){
            $result = ['success' => 0, 'message' => 'test time is ended'];
            die(json_encode($result));
        }

        $rs = ['success' => 1, 'message' => 'its all ok for now!'];

        $test_number = \request()->get('test_number');
        $checked = \request()->get('checked');
        $checked = $checked === "true" ? true : false;
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
        //$question_type = 1; // xD
        $question_type = intval(\request()->get('qst_type'));

        // #3 исходя из 2 подсунуть нужный для сохранения
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
                        ->update(['qsts_answer' => $question_id]);
                    $rs = ['success' => 1, 'message' => 'saved!'];
                }catch (\Exception $e){
                    $rs = ['success' => 0, 'message' => $e->getLine() . '_' . $e->getFile() . '_' . $e->getMessage()];
                    break;
                }
                break;

            case 2:
                try{
                    $ssq = SavedSelectedQst::where('test_number','=',$test_number)
                        ->where('qsts_number','=',$question_number);
                    //echo Debug::d($ssq->get()->toArray());
                    $question_ids = strval($ssq->get()->toArray()[0]['qsts_answer']);
                    $question_ids_array = explode(';', $question_ids);

                    $newQuestionIds = $question_ids;

                    if ($checked){
                        if (!in_array($question_id, $question_ids_array)){
                            $newQuestionIds .= $question_id . ';';
                        }
                    }else{
                        if (in_array($question_id, $question_ids_array)){
                            $copy_question_ids_array = $question_ids_array;
                            foreach($copy_question_ids_array as $k => $v){
                                if ($copy_question_ids_array[$k] === strval($question_id)){
                                    unset($copy_question_ids_array[$k]);
                                }
                            }
                            $newQuestionIds = implode(';', $copy_question_ids_array);
                        }
                    }

                    $ssq->update(['qsts_answer' => $newQuestionIds]);
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

    /**
     * Закончилось ли время тестировани?
     * @return bool
     */
    public function isTestTimeEnded():bool{
        //diffInSeconds	58
        //etalonDiffInSeconds	1980
        $testTimeDiffs = $this->getTimeDiff();
        return $testTimeDiffs['diffInSeconds'] >= $testTimeDiffs['etalonDiffInSeconds'];
    }

    /**
     * Обертка над $this->isTestTimeEnded в виде die($json)
     */
    public function isTestTimeEndedAjax(){
        $result = $this->isTestTimeEnded();
        die(json_encode($result));
    }

    /**
     * Получение разницы времени между началом и текущим времени тестирования в разных форматах
     * @return array
     */
    public function getTimeDiff(){

        $rs = ['success' => 1, 'its all fine!'];

        $started_config_key = config('services.sts.test_start_session_key');

        if (!session()->has($started_config_key)) {
            $rs = ['success' => 0, '$started_config_key is not exists!'];
            return $rs;
        }

        $arrSession = session()->get($started_config_key);
        $rs['duration']['minutes'] = $arrSession['duration'];
        $test_started_at = TestResult::where('test_number','=', $arrSession['test_number'])
            ->get()->first()->test_started_at;
        $rs['test_started_at'] = $test_started_at;
        $rs['test_started_at'] = Carbon::parse($test_started_at, 'Europe/Moscow');
        $rs['test_started_now'] = Carbon::now('Europe/Moscow');
        $rs['diffInMinutes'] = $rs['test_started_now']->diffInMinutes($rs['test_started_at']);
        $rs['diffInSeconds'] = $rs['test_started_now']->diffInSeconds($rs['test_started_at']);
        $rs['etalonDiffInSeconds'] = $rs['duration']['minutes'] * 60;

        return $rs;
    }

    /**
     * Обертка над $this->getTimeDiff() в виде die($json)
     */
    public function getTimeDiffAjax(){
        $rs = $this->getTimeDiff();
        die(json_encode($rs));
    }
}