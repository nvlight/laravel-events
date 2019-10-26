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
        //dd($question_theme_id);

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
                    $errors[] = 'Description is empty';
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
                    $errors[] = 'No one true answer';
                }
                if (!$one_false_answer){
                    $errors[] = 'No one false answer';
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
                            $errors[] = 'One of answers is empty';
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

        //dd($request->all());
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
     * Display the specified resource.
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
        $themes = Question::where('description_type', '=', 7)->get();
        //dd($themes);

        $themesWichQustionChilds = Question::whereIn('description_type', [1,7])->get()->toArray();
        //echo Debug::d($themesWichQustionChilds); die;
        $catsThemesWithQuestionChilds = self::createTree($themesWichQustionChilds);
        //echo Debug::d($catsThemesWithQuestionChilds); die;
        //dd($themesWichQustionChilds);

        //echo Debug::d($test_curr->parent_id);
        //die;
        $questions = Question::where('parent_id','=',$test_curr->id)->get();
        //dd($questions);
        //return $simple_test_system_question;

        return view('simpletestsystem.question.index',
            compact('question_types', 'test_curr', 'tests', 'questions', 'themes', 'catsThemesWithQuestionChilds')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SimpleTestSystem\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
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
