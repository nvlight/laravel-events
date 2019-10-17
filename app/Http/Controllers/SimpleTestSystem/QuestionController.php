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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $question_type = intval($request['question_type']);
        $question_theme_id = $request['question_theme_id'] ?? 0;
        //dd($question_theme_id);

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
                $errors = [];

                // now need to now, question number in table, then get number + 1
                $number = 0;
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
                if (count($errors)){
                    session()->flash('add_question_error', implode(' ', $errors));
                    break;
                }

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
                }
                if (count($errors)){
                    session()->flash('add_question_error', implode(' ', $errors));
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
                    session()->flash('add_question_error', implode(' ', $errors));
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
                    session()->flash('add_question_error', implode(' ', $errors));
                    break;
                }

                //echo Debug::d($question); die;

                // well ! we need add questions data!
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

                if (count($errors)){
                    session()->flash('add_question_error', implode(' ', $errors));
                    break;
                }

                session()->flash('add_question_success', 'Вопрос добавлен, ага!');
                break;
            default:
                session()->flash('add_question_error', 'Что-то пошло не так!');
        }

        //echo Debug::d($answered);
        //die;

        return back();
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

        //echo Debug::d($test_curr->parent_id);
        //die;
        $questions = Question::where('parent_id','=',$test_curr->id)->get();
        //dd($questions);
        //return $simple_test_system_question;

        return view('simpletestsystem.question.index',
            compact('question_types', 'test_curr', 'tests', 'questions', 'themes')
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SimpleTestSystem\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }

    //
    public function add_theme(Test $question, Request $request){
        //return $question;

        //echo Debug::d($question->parent_id);
        $errors = [];

        $question1 = new Question();
        $question1->parent_id = $question->id;

        $question1->type = 0;

        // надо сначала найти максимальный number и +1 от него
        $number = 0;
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
        $question1->number = $number;

        $question1->description = $request['theme'];

        $question1->description_type = 7; // type for theme

        $question1->theme_id = 0;

        //dd($question1);
        $question1->save();

        session()->flash('add_question_theme', 'Тема добавлена!');

        return back();
    }
}
