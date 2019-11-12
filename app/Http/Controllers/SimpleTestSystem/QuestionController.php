<?php

namespace App\Http\Controllers\SimpleTestSystem;

use App\Debug;
use App\Models\SimpleTestSystem\Question;
use App\Models\SimpleTestSystem\QuestionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SimpleTestSystem\Test;
use Illuminate\Support\Facades\Validator;


class QuestionController extends Controller
{
    protected static $deleteQuestionChilds;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('simpletestsystem.question.index');
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
    public function storeReal($question){

        $errors = [];
        try {
            \DB::transaction(function () use($question) {

                foreach($question as $qk => $qv){
                    $question = new Question();
                    $question->parent_id = $qv['parent_id'];
                    $question->type = $qv['type'];
                    $question->number = $qv['number'];
                    $question->description = $qv['description'];
                    $question->description_type = $qv['description_type'];
                    $question->theme_id = $qv['theme_id'];
                    //dump($question);
                    $question->save();
                }
            });
        }catch (\Exception $e){
            $errors[] = $e->getCode() . ' | ' . $e->getMessage();
        }
        //echo Debug::d($errors); die;

        $result = ['success' => 1];
        if (count($errors))
            $result = ['success' => 0, 'message' => 'Что-то пошло не так', 'errors' => $errors];

        return $result;

    }

    /**
     * @param $question_type
     * @param $request
     * @return array
     * @throws \Throwable
     */
    public function validateQuestionForClosedType($question_type, $request){

        $question_theme_id = $request['question_theme_id'] ?? 0;
        //dump($question_theme_id);

        if (intval($question_theme_id) === 0){
            $result = ['success' => 0, 'errors' => 'Вопрос должен быть включен в тему!'];
            return $result;
        }

        $errors = [];
        switch ($question_type){
            case 1:
                //question_type	"1"
                //question_description	"questin1 ?"
                //answer1	"a1"
                //hidden_answer_1	"1"
                //answer2	"a2"
                //hidden_answer_2	"0"
                //answer3	"a3"
                //hidden_answer_3	"0"
                //answer4	"a4"
                //hidden_answer_4	"0"
                $question = [];

                // now need to now, question number in table, then get number + 1
                $getLastInsertNumber = $this->getLastInsertNumber();
                if ($getLastInsertNumber['success'] === 0){
                    $errors[] = $getLastInsertNumber['message'];
                    break;
                }
                $number = $getLastInsertNumber['number'];

                $question_tmp = [
                    'parent_id' => intval($request['parent_id']),
                    'number' => $number,
                    'type' => intval($request['question_type']),
                    'theme_id' => $question_theme_id,
                ];

                //dd($request->all());
                // description is empty?
                $validator = Validator::make($request->all(), [
                    'question_description' => 'min:3',
                ]);
                if ($validator->fails()){
                    $errors[] = 'Пустое описание вопроса';
                    break;
                }

                $question_main = $question_tmp;
                $question_main['description'] = $request['question_description'];
                $question_main['description_type'] = 1;

                $question[] = $question_main;

                $input = $request->all();
                //echo Debug::d($input); //die;
                $answered = []; $i = 0;
                foreach($input as $k => $v){
                    //echo $k . ' : ' . $v;
                    if (preg_match("/^answer(\d)$/ui",$k,$rs1)){

                        //$answered[$v] = $input['hidden_answer_' . $rs1[1]];

                        $pattern = "/^hidden_answer_(".$rs1[1].")$/ui";
                        foreach($input as $kk => $vv) {

                            //echo Debug::d($pattern);
                            if (preg_match($pattern, $kk, $rs2)) {
                                //echo Debug::d($rs2);

                                $answered[$v] = $input['hidden_answer_' . $rs2[1]];

                                $tmp_answer = $question_tmp;
                                $tmp_answer['description'] = $v;
                                $tmp_answer['description_type'] = intval($input['hidden_answer_' . $rs2[1]]);

                                $question[] = $tmp_answer;

                                $i++;

                                if ($i == 4) {
                                    //echo Debug::d($v);
                                    //echo Debug::d($input['hidden_answer_' . $rs2[1]]);
                                    //die;
                                }
                            }
                        }
                    }
                }

                // проверки теперь
                // проверка на существование вопроса и min:3
                // есть ли хотя бы 1 правильный и неправильный ответ

                $one_true_answer = false; $one_false_answer = false;
                //dd($question);
                // are we have one true and false answer?
                foreach($question as $k => $v){
                    if ($v['description_type'] === 2) {
                        $one_true_answer = true;
                    }
                    if ($v['description_type'] === 3) {
                        $one_false_answer = true;
                    }
                }
                if (!$one_true_answer){
                    $errors[] = 'Не выбрано ни одного правильного ответа';
                }
                if (!$one_false_answer){
                    $errors[] = 'Не выбрано ни одного неправильного ответа';
                }
                if (count($errors)){
                    break;
                }

                // is one of answers empty?
                foreach($question as $k => $v)
                    if ($v['description_type'] == 2 || $v['description_type'] == 3)
                    {
                        $validator = Validator::make($v, [
                            'description' => 'min:1',
                        ]);
                        if ($validator->fails()){
                            $errors[] = 'Один из ответов не имеет описания!';
                            break;
                        }
                    }
                if (count($errors)){
                    break;
                }

                break;
            default:
                $errors[] = 'Что-то пошло не так!';
        }

        $result = ['success' => 1, 'question' => $question];
        if (count($errors)){
            $result = ['success' => 0, 'errors' => implode('|', $errors)];
            return $result;
        }

        return $result;
    }

    //
    public function store(Request $request){

        //dump($request->all());
        $question_type = intval($request['question_type']);

        switch ($question_type){
            case 1:
                $validateQuestionForClosedType = $this->validateQuestionForClosedType($question_type, $request);
                if ($validateQuestionForClosedType['success'] !== 1)
                    break;

                // нужно проверить, если ли у вопроса больше 1 правильного ответа, это обязательное условие для этого типа вопроса
                $trueCount = 0;
                foreach($validateQuestionForClosedType['question'] as $qk => $qv)
                    if ($qv['description_type'] == 2) $trueCount++;
                //dd($trueCount);
                if ($trueCount > 1){
                    $validateQuestionForClosedType = ['success' => 0, 'errors' => 'Правильных ответов должно быть не более 1 !',
                        'question' => $validateQuestionForClosedType['question'] ];
                    break;
                }
                break;
            case 2:
                $validateQuestionForClosedType = $this->validateQuestionForClosedType(1, $request);
                if ($validateQuestionForClosedType['success'] !== 1)
                    break;

                // нужно проверить, если ли у вопроса больше 1 правильного ответа, это обязательное условие для этого типа вопроса
                $trueCount = 0;
                foreach($validateQuestionForClosedType['question'] as $qk => $qv){
                    if ($qv['description_type'] == 2) $trueCount++;
                    if ($trueCount == 2) break;
                }
                if ($trueCount !== 2){
                    $validateQuestionForClosedType = ['success' => 0, 'errors' => 'Правильных ответов должно быть не менее 2-х!',
                        'question' => $validateQuestionForClosedType['question'] ];
                    break;
                }
                break;
            default:
                $validateQuestionForClosedType = ['success' => 0, 'message' => 'false!', 'errors' => 'Что-то пошло не так!'];
        }

        if ($validateQuestionForClosedType['success'] !== 1){
            $result = ['success' => 0, 'message' => 'done!', 'errors' => $validateQuestionForClosedType['errors'] ];
            return response()->json($result);
        }
        //$result = ['success' => 0, 'message' => 'done!'];
        //return response()->json($result);
        $question = $validateQuestionForClosedType['question'];

        $storeResult = $this->storeReal($question);

        session()->flash('add_question_success', 'Вопрос добавлен!');
        if ($storeResult['success'] !== 1){
            session()->flash('add_question_error', implode('|', $storeResult['errors']));
        }

        return response()->json($storeResult);
    }

    //
    public function updateTheme(Question $theme, Request $request){
        //return $request;
        $validator = Validator::make($request->all(), [
            'theme' => 'min:2|max:222',
        ]);
        $errors = [];
        if ($validator->fails()){
            $errors[] = $validator->errors();
            //dd($errors);
        }
        if (count($errors)){
            session()->flash('theme_edit', ["success" => 0, 'message' => "Тема должна состоять из минимум 2 символов"] );
            return back();
        }

        try{
            $theme->description = $request->get('theme');
            $theme->save();
            session()->flash('theme_edit', ["success" => 1, 'message' => "Изменения сохранены!"] );
        }catch (\Exception $e){
            session()->flash('theme_edit', ["success" => 0, 'message' => "Ошибка при сохранении темы!"] );
        }

        return back();
    }

    //
    public function editTheme(Question $theme){
        //return $theme;

        return view('simpletestsystem.theme.edit', compact('theme'));
    }

    //
    public function editQuestion(Question $question){
        //return $question;

        // в зависимости от description_type нужно нужно показать соотв. форму редактирования
        // для темы - просто редактируем название
        // для вопроса сложнее, нужно найти все его дочерние элементы по номеру, далее нужно все это показать
        // и добавить средства для правки самого вопроса, добавления, удаления вопросов, изменение правильных ответов
        // также нужно пока что запретить там возможность изменить тип вопроса!

        // #1 для начала найдем вопрос по parent_id && number
        $question_ids = Question::where('parent_id', '=', $question->parent_id)
            ->where('number','=', $question->number)
            ->get()
        ;
        //dd($question_ids);

        return view('simpletestsystem.question.edit', compact('question', 'question_ids'));
    }

    /**
     * Получение количества ответов по типу, например по (не)правильным ответам для вопроса
     *
     * @param array $questions массив, по которому будет идти поиск
     * @param int $description_type тип, по которому будет идти сравнение
     * @return int количество ответов по типу
     **/
    public function getQuestionAnswersByDescriptionType(array $questions, int $description_type){

        $count = 0;
        switch ($description_type){
            case 2:
                foreach($questions as $k => $v){
                    if ($v['description_type'] === $description_type){
                        $count++;
                    }
                }
                break;
            case 3:
                foreach($questions as $k => $v){
                    if ($v['description_type'] === $description_type){
                        $count++;
                    }
                }
                break;
            default:
        }
        return $count;
    }

    /**
     * Получения вопроса с дочерними ответами
     *
     * @param int $parent_id - id предка
     * @param int $number - номер вопроса
     * @return mixed объект с полученным вопросом
     */
    public function getQuestionWithChildAnswersByParentIdAndByNumber(int $parent_id, int $number){
        return $qst_ids = Question::where('number', '=', $number)
            ->where('parent_id','=', $parent_id)
            ->get();
    }

    /**/
    public function deleteQuestion(Question $question){

        //dd($question);

        $qst_ids = $this->getQuestionWithChildAnswersByParentIdAndByNumber($question->parent_id, $question->number);

        $qst_ids_count = $qst_ids->count();
        if ($qst_ids_count === 0){
            $rs = ['success' => 0, 'message' => 'Не найдено потомков вопроса'];
            //dd($rs);
            session()->flash('del_question', $rs['message']);
            return back();
        }

        $qst_ids_array = $qst_ids->toArray();
        //dd($qst_ids_array);

        $trueAnsersCount  = $this->getQuestionAnswersByDescriptionType($qst_ids_array, 2);
        $falseAnsersCount = $this->getQuestionAnswersByDescriptionType($qst_ids_array, 3);
        //dump($trueAnsersCount);
        //dump($falseAnsersCount);

        $current_answer_type = $question->description_type;
        //dd($current_answer_type);
        switch ($current_answer_type){
            case 2:

                // если правильных ответов 2, то при удалении нужно изменить тип вопроса на закрытый с 1 прав.ответом
                if ($trueAnsersCount == 2){
                    $changeType = $this->setQuestionChildsType($qst_ids, 1);
                    if ($changeType['success'] !== 1){
                        session()->flash('del_question', $changeType['message']);
                        return back();
                    }
                    break;
                }

                if ($trueAnsersCount < 2){
                    $rs = ['success' => 0, 'message' => 'Невозможно удалить единственный оставшийся правильный ответ'];
                    session()->flash('del_question', $rs['message']);
                    //dd($rs);
                    return back();
                }
                break;
            case 3:
                if ($falseAnsersCount < 2){
                    $rs = ['success' => 0, 'message' => 'Невозможно удалить единственный оставшийся неправильный ответ'];
                    session()->flash('del_question', $rs['message']);
                    //dump($falseAnsersCount);
                    //dd($rs);
                    return back();
                }
                break;
            default:
                $rs = ['success' => 0, 'message' => 'Неизвестный тип вопроса'];
                session()->flash('del_question', $rs['message']);
                //dd($rs);
                return back();
        }

        //dd('okey');

        $rs = ['success' => 1, 'message' => 'Запись удалена!'];
        try{
            $question->delete();
        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'Что-то пошло не так!'];
        }
        session()->flash('del_question', $rs['message']);

        //return response()->json($rs);
        return back();
    }

    //
    public function updateQuestionDescription(Request $request){

        $rs = ['success' => 1, 'message' => 'its cool!', 'request' => $request->all()];

        $validator = Validator::make($request->all(), [
            'question_description' => 'min:2|max:222',
            'qst_id' => 'int|min:1',
        ]);
        $errors = [];
        if ($validator->fails()){
            $errors[] = $validator->errors();
            //dd($errors);
        }
        if (count($errors)){
            $rs = ["success" => 0, 'message' => "Символов меньше 2!"];
            return response()->json($rs);
        }

        try{
            $question = Question::where('id', '=', intval($request->get('qst_id')) )->get()->first();
            $question->description = $request->get('question_description');
            $question->save();
            $rs = ["success" => 1, 'message' => "Изменения сохранены!"];
        }catch (\Exception $e){
            $rs = ["success" => 0, 'message' => "Ошибка при сохранении описания вопроса!",
                'error' => $e->getMessage(), 'qst' => $question->toArray()
            ];
        }

        return response()->json($rs);
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
     * Show TZ child themes and questions
     *
     * @param  \App\Models\SimpleTestSystem\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Test $simple_test_system_question)
    {
        //return $simple_test_system_question;
        $test_curr = $simple_test_system_question;
        $question_types = QuestionType::all();
        $tests = Test::all();
        $themes = Question::where('description_type', '=', 7)
            ->where('parent_id', '=', $simple_test_system_question->id)
            ->get();
        //dd($themes);

        session()->put('tz', $test_curr);

        $themesWichQustionChilds = Question::whereIn('description_type', [1,7])
            ->where('parent_id', '=', $simple_test_system_question->id)
            ->get()->toArray();
        //echo Debug::d($themesWichQustionChilds); die;
        $catsThemesWithQuestionChilds = self::createTree($themesWichQustionChilds);
        //echo Debug::d($catsThemesWithQuestionChilds); die;
        //dd($catsThemesWithQuestionChilds);

        //echo Debug::d($test_curr->parent_id);
        //die;
        $questions = Question::where('parent_id','=',$test_curr->id)
            ->orderBy('theme_id', 'asc')
            ->orderBy('number', 'asc')
            ->get();
        //dd($questions);
        //return $simple_test_system_question;

        return view('simpletestsystem.question.index',
            compact('question_types', 'test_curr', 'tests', 'questions', 'themes', 'catsThemesWithQuestionChilds')
        );
    }

    //
    public function showQuestion(Question $question){
        //return $question;
        return view('simpletestsystem.question.show',
            compact('question'));
    }

    //
    public function showTheme(Question $theme){
        //return $theme;
        return view('simpletestsystem.theme.show',
            compact('theme'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SimpleTestSystem\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $theme)
    {
        //return $theme;
        $this->editTheme($theme);
    }

    /**
     * @param Question $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestion(Question $question){
        $rs = ['success' => 1, 'description' => $question->description];
        return response()->json($rs);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateAnswerBeforeAdd(Request $request){

        $rs = ['success' => 1];

        $validator = Validator::make($request->all(), [
            'description_type' => 'int|min:2|max:3',
            // 'description_type' => 'int|between:2,3',
            'description' => 'string|min:1|max:222',
        ]);
        $errors = [];
        if ($validator->fails()){
            $errors[] = $validator->errors();
        }
        if (count($errors)){
            $rs['success'] = 0;
            $rs['errors'] = $errors;
        }
        return $rs;
    }

    /**
     * @param Question $question
     * @param Request $request
     * @return array
     */
    public function storeAnswer(Question $question, Request $request){
        $rs = ['success' => 1];
        try{
            $answer = new Question();
            $answer->number = $question->number;
            $answer->description = $request->get('description');
            $answer->description_type = $request->get('description_type');
            $answer->parent_id = $question->parent_id;
            $answer->theme_id = $question->theme_id;
            $answer->type = $question->type;
            $answer->save();
            session()->flash('add_questionAnswer', 'Ответ добавлен к вопросу');
        }catch (\Exception $e){
            $rs['success'] = 0;
            $rs['errors'] = $e->getMessage();
            $rs['message'] = 'Ошибка при добавлении!';
        }
        return $rs;
    }

    /**
     * @param Question $question
     * @param Request $request
     * @return array
     */
    public function addAnwerBefore(Question $question, Request $request){

        //dd($question);

        $validateAnswer = $this->validateAnswerBeforeAdd($request);
        if ($validateAnswer['success'] === 0){
            return $validateAnswer;
        }

        $qst_ids = $this->getQuestionWithChildAnswersByParentIdAndByNumber($question->parent_id, $question->number);
        $qst_ids_count = $qst_ids->count();
        if ($qst_ids_count === 0){
            $rs = ['success' => 0, 'message' => 'Не найдено потомков вопроса'];
            return $rs;
        }
        $qst_ids_array = $qst_ids->toArray();
        //dd($qst_ids_array);

        $trueAnsersCount  = $this->getQuestionAnswersByDescriptionType($qst_ids_array, 2);
        $falseAnsersCount = $this->getQuestionAnswersByDescriptionType($qst_ids_array, 3);
        //dump($trueAnsersCount);
        //dump($falseAnsersCount);

        $dbg_data = [$qst_ids_array];
        $rs = ['success' => 1, '$dbg_data' => $dbg_data,
            'trueAnsersCount' => $trueAnsersCount, 'falseAnsersCount' => $falseAnsersCount,
            'qst_childs' => $qst_ids,
        ];

        return $rs;
    }

    /**
     * @param Question $question
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAnswer(Question $question, Request $request){

        $addAnwerBefore = $this->addAnwerBefore($question, $request);
        if ($addAnwerBefore['success'] === 0){
            return response()->json($addAnwerBefore);
        }

        //$rs = ['success' => 2, 'desc' => $request->get('description_type'), gettype(intval($request->get('description_type')))];
        //return response()->json($rs);

        // если добавляем правильный ответ, то должны предупредить, что это приведет к изменения типа вопроса
        // с закрытого с 1 правильным ответом на тот же закрытый с 2-я и более правильными ответами
        if ( intval($request->get('description_type')) === 2 && $addAnwerBefore['trueAnsersCount'] === 1 ){
            $rs = [
                'success' => 2,
                'message' => <<<STR
Попытка добавления 2 правильного ответа. 
Это приведет к изменению типа вопроса (Закрытый тип, два и более правильных ответов). 
Требуется подтверждение действия. 
Подтвердить изменения типа вопроса и добавления правильного ответа?
STR
            ];
            return response()->json($rs);
        }

        $store = $this->storeAnswer($question, $request);

        return response()->json($store);
    }

    /**
     * @param $question_childs
     * @param $type
     * @return array
     * @throws \Throwable
     */
    public function setQuestionChildsType($question_childs, $type){

        $result = ['success' => 1, 'transaction is done'];
        try{
            \DB::transaction(function () use($question_childs, $type) {
                foreach($question_childs as $qk => $qv){
                    $question_child = $qv;
                    $question_child->type = $type;
                    $question_child->save();
                }
            });
        }catch (\Exception $e){
            $result = ['success' => 0, 'message' => 'transaction is failed', 'error' => $e->getCode() . ' || ' . $e->getMessage()];
        }
        return $result;
    }

    /**
     * @param Question $question
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAnswerConfirm(Question $question, Request $request){

        $addAnwerBefore = $this->addAnwerBefore($question, $request);
        if ($addAnwerBefore['success'] === 0){
            return response()->json($addAnwerBefore);
        }

        $is_question_type_changed = false;
        if ( intval($request->get('description_type')) === 2 && $addAnwerBefore['trueAnsersCount'] === 1 ){
            // нужно сменить тип вопроса на закрытый с несколькими правильными ответами.
            $qst_childs =  $addAnwerBefore['qst_childs'];

            $rs = $this->setQuestionChildsType($qst_childs, 2);

            $is_question_type_changed = true;

            if ($rs['success'] === 0){
                return response()->json($rs);
            }

        }

        if ($is_question_type_changed){
            $question->type = 2;
            try {
                $question->save();
            }catch (\Exception $e){
                $rs = ['success' => 0, 'message' => 'Ошибка при изменения типа перед сохранением!'];
                return response()->json($rs);
            }
        }

        $store = $this->storeAnswer($question, $request);

        return response()->json($store);
    }

    //
    public function updateAnswer(Question $question, Request $request){

        $rs = ['success' => 1, 'message' => 'Вопрос обновлен!'];

        $validator = Validator::make($request->all(), [
            'answer_type' => 'int|min:2|max:3', // 'description_type' => 'int|between:2,3',
            'description' => 'string|min:1|max:222',
        ]);
        $errors = [];
        if ($validator->fails()){
            $errors[] = $validator->errors();
        }
        if (count($errors)){
            $rs['success'] = 0;
            $rs['errors'] = $errors;
            $rs['message'] = 'Что-то пошло не так';
        }else{
            try{
                $question->description = $request->get('description');
                $question->description_type = $request->get('answerType');
                $question->save();
                session()->flash('update_questionAnswer', 'Ответ обновлен');
            }catch (\Exception $e){
                $rs['success'] = 0;
                $rs['errors'] = [[$e->getMessage()]];
                $rs['message'] = 'Ошибка при обновлении!';
            }

        }

        return response()->json($rs);
    }

    //
    public function getAnswer(Question $question){

        $rs = ['success' => 1, 'message' => 'get this', 'data' => $question];

        return response()->json($rs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SimpleTestSystem\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    //
    public static function getAllChildsByThemeId($questions, $id){

        $ids = [];
        //dd($ids);
        foreach($questions as $k => $v){
            if($v['theme_id'] == $id){
                self::$deleteQuestionChilds[] = $v;
                $ids[] = $v;
                $ids[] = self::getAllChildsByThemeId($questions, $v['id']);
            }
        }
        return $ids;
    }

    //
    public function getQuestionChildIds(array $question, int $number):array{
        $result = [];
        //echo Debug::d($number);
        //dd($question);
        //dd($number);
        foreach($question as $q)
            if ($q['number'] === $number)
                $result[] = $q['id'];

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     * Удаление темы или вопроса
     *
     * @param  \App\Models\SimpleTestSystem\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $simple_test_system_question)
    {
        //return $simple_test_system_question;

        $questions = Question::where('parent_id', '=', $simple_test_system_question->parent_id)
            ->select('id','theme_id', 'number','description_type')
            ->get()->toArray();
        //all('id','theme_id', 'number','description_type')->toArray();
        //dd($questions);

        //
        switch ($simple_test_system_question['description_type']){
            case 1:
                $deleteAllChildsByThemeId = $this->getQuestionChildIds($questions, $simple_test_system_question->number);
                //dd($deleteAllChildsByThemeId);
                break;

            case 7:
                self::$deleteQuestionChilds = [];
                self::$deleteQuestionChilds[] = $simple_test_system_question->toArray();

                $deleteAllChildsByThemeId = (self::getAllChildsByThemeId($questions, $simple_test_system_question->id));
                //echo Debug::d(self::$deleteQuestionChilds); die;
                //dd($deleteAllChildsByThemeId);

                $deleteAllChildsByThemeIdWithQuestionChildIds = [];
                if (count(self::$deleteQuestionChilds))
                foreach(self::$deleteQuestionChilds as $k => $v){
                    if ($v['description_type'] === 1){
                        //dd($v);
                        $curr_qustion_child_ids = $this->getQuestionChildIds($questions, $v['number']);
                        //dd($curr_qustion_child_ids);
                        foreach($curr_qustion_child_ids as $kk => $vv) $deleteAllChildsByThemeIdWithQuestionChildIds[] = $vv;
                    }else{
                        $deleteAllChildsByThemeIdWithQuestionChildIds[] = $v['id'];
                    }
                }
                //echo Debug::d($deleteAllChildsByThemeIdWithQuestionChildIds); die;

                $deleteAllChildsByThemeId = $deleteAllChildsByThemeIdWithQuestionChildIds;

                break;

            default:
                session()->flash('del_question', "Что-то пошло не так!");
                return back();
        }

        $errors = [];
        try {
            \DB::transaction(function () use(&$deletedRaws, $deleteAllChildsByThemeId) {
                //dd($deleteAllChildsByThemeIdIdsWithotSpaces);
                $deletedRaws = \DB::table('questions')->whereIn('id', $deleteAllChildsByThemeId)->delete();
                // ('DELETE FROM questions WHERE id IN ' . $deleteAllChildsByThemeId);
                // Question::delete();
                // dd($deletedRaws);
            });
        }catch (\Exception $e){
            $errors[] = $e->getCode() . ' | ' . $e->getMessage();
        }
        //dd($errors);
        if (count($errors)){
            session()->flash('del_question', 'Ошибка при удалении!');
            return back();
        }

        //$simple_test_system_question->delete();
        //$object = $simple_test_system_question->description_type === 7 ? 'Тема удалена' : 'Вопрос удален';
        switch ($simple_test_system_question->description_type){
            case 7:
                $message = 'Тема удалена вместо со всеми потомками. Всего удалено записей - ' . $deletedRaws;
                break;
            case 1:
                $message = 'Вопрос удален';
                break;
            default:
                $message = "Что-то пошло не так!";
        }

        session()->flash('del_question', $message);
        return back();
    }

    //
    public function getLastInsertNumber(){

        // надо сначала найти максимальный number и +1 от него
        $number = 0; $errors = [];
        try {
            $rs = \DB::table('questions')
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

    //
    public function store_theme_real($question, $request){

        //echo Debug::d($question->parent_id);
        $errors = [];

        $question1 = new Question();

        $question1->parent_id = $question->id;
        $question1->type = 0;

        $getLastInsertNumber = $this->getLastInsertNumber();

        if ($getLastInsertNumber['success'] === 0)
            return ['success' => 0, 'message' => $getLastInsertNumber['message']];

        $question1->number = $getLastInsertNumber['number'];
        $question1->description = $request['theme'];
        $question1->description_type = 7; // type for theme
        $question1->theme_id = intval($request['theme_parent']);
        //dd($question1);

        try{
            $question1->save();
        }catch (\Exception $e){
            $errors[] = $e->getCode() . ' | ' . $e->getMessage();
        }

        $result = ['success' => 1];
        if (count($errors))
            $result = ['success' => 0, 'errors' => $errors];

        return $result;
    }

    //
    public function store_theme(Test $question, Request $request){
        //return $question;

        $validator = Validator::make($request->all(), [
            'theme' => 'min:2',
            'theme_parent' => 'int|min:0',
        ]);
        $errors = [];
        if ($validator->fails()){
            $errors[] = $validator->errors();
        }
        if (count($errors)){
            $validateTheme = ['success' => 0, 'message' => $errors[0]];
            session()->flash('add_question_theme', $validateTheme);
            return back();
        }

        $storeTheme = $this->store_theme_real($question, $request);

        if ( $storeTheme['success'] !== 1 ){
            $validateTheme = ['success' => 0, 'message' => 'Ошибка при добавлении темы!']; // . implode('|', $storeTheme['errors'])
            session()->flash('add_question_theme', $validateTheme);
        }else{
            $validateTheme = ['success' => 1, 'message' => 'Тема добавлена!'];
            session()->flash('add_question_theme', $validateTheme);
        }

        return back();
    }

}
