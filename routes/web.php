<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//
//    $logined = auth()->id();
//
//    if ($logined !== null){
//        return redirect('/event');
//    }
//
//    return redirect('/tests');
//});

Route::get('/','HomeController@index');
Route::get('/tests', 'SimpleTestSystem\HhController@index');//->middleware('guest');
Route::get('/tests/resume','SimpleTestSystem\HhController@testResume');
Route::get('/tests/destroy-ss','SimpleTestSystem\HhController@destroyUserSession');
Route::get('/tests/get-time-diff','SimpleTestSystem\HhController@getTimeDiff');
Route::get('/tests/get-test-results-with-testParams', 'SimpleTestSystem\HhController@countingResultBallsByRequest');//->middleware('guest');
Route::get('/tests/isTetsTimeElapsed','SimpleTestSystem\HhController@isTestTimeEndedAjax');
Route::get('/tests/{shedule_id}', 'SimpleTestSystem\HhController@showThemes');//->middleware('guest');
Route::post('/tests/start', 'SimpleTestSystem\HhController@testStart');//->middleware('guest');
Route::post('/tests/results','SimpleTestSystem\HhController@testResults');
Route::patch('tests/save-single-result','SimpleTestSystem\HhController@saveSingleQuestionResultByClickWithAjax');

Route::get('/test_getQuestionByTetsIdAndNumber', 'SimpleTestSystem\HhController@test_getQuestionByTetsIdAndNumber');
Route::get('/test_testCheckBoxAnswerIsTrue', 'SimpleTestSystem\HhController@test_testCheckBoxAnswerIsTrue');
Route::get('/test_countingResultBallsByRequest','SimpleTestSystem\HhController@test_isCheckboxQuestionTrue');

Auth::routes(['verify' => false]);

Route::resource('category', 'EventCategoryController')->middleware('verified');
Route::resource('type', 'EventTypeController')->middleware('verified');
Route::resource('event', 'EventController')->middleware('verified');
Route::resource('shorturl', 'ShortUrlController')->middleware('verified');

Route::get('exchange-rate', 'ExchangeRateController@index')->middleware('verified');
Route::get('exchange-rate-update', 'ExchangeRateController@getLastExchangeRateHtml')->middleware('verified');
//Route::get('exchange-rate-test', 'ExchangeRateController@getLastExchangeRate')->middleware('verified');

Route::get('youtube_watch/{ytVideoId}', 'YouTubeController@watch')->middleware('verified');
Route::get('youtube_search', 'YouTubeController@search')->middleware('verified');
Route::post('youtube_search', 'YouTubeController@search')->middleware('verified');

Route::get('document', 'DocumentController@index')->middleware('verified');
Route::get('events-graphics', 'EventController@graphics_index')->middleware('verified');
Route::get('su/{shorturl}', 'ShortUrlController@getShortUrl');

//Route::post('document-load', 'DocumentController@upload')->middleware('verified');
Route::resource('document', 'DocumentController')->middleware('verified');
Route::get('document-download/{document}','DocumentController@download')->middleware('verified');

//Route::get('test111', 'TestController@show')->name('tttest.note');
//Route::get('verification.notice', 'TestController@show')->name('tttest.note');

//Route::get('email/verify', 'auth\VerificationController@show')->name('tttest.note');
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('event-filter', 'EventController@filter')->middleware('verified');
Route::get('shorturl-filter', 'ShortUrlController@filter')->middleware('verified');

Route::resource('simple-test-system', 'SimpleTestSystem\CategoryController')->middleware('verified');
Route::resource('simple-test-system-test', 'SimpleTestSystem\TestController')->middleware('verified');
Route::resource('simple-test-system-question', 'SimpleTestSystem\QuestionController')->middleware('verified');

Route::post('simple-test-system-question-theme/{question}', 'SimpleTestSystem\QuestionController@store_theme')->middleware('verified');
Route::post('sts-add-question', 'SimpleTestSystem\QuestionController@store')->middleware('verified');

Route::get('sts-theme/{theme}', 'SimpleTestSystem\QuestionController@showTheme')->middleware('verified');
Route::get('sts-theme/{theme}/edit', 'SimpleTestSystem\QuestionController@editTheme')->middleware('verified');
Route::patch('sts-theme/{theme}', 'SimpleTestSystem\QuestionController@updateTheme')->middleware('verified');

Route::get('sts-question/{question}', 'SimpleTestSystem\QuestionController@showQuestion')->middleware('verified');
Route::get('sts-question/{question}/edit', 'SimpleTestSystem\QuestionController@editQuestion')->middleware('verified');

Route::get('sts-question/{question}/get', 'SimpleTestSystem\QuestionController@getQuestion')->middleware('verified');
Route::delete('sts-question/{question}', 'SimpleTestSystem\QuestionController@deleteQuestion')->middleware('verified');
Route::patch('sts-question-update-description', 'SimpleTestSystem\QuestionController@updateQuestionDescription')->middleware('verified');
Route::post('sts-question-add-answer/{question}', 'SimpleTestSystem\QuestionController@addAnswer')->middleware('verified');
Route::post('sts-question-add-answer-confirm/{question}', 'SimpleTestSystem\QuestionController@addAnswerConfirm')->middleware('verified');
Route::get('sts-question-get-answer/{question}', 'SimpleTestSystem\QuestionController@getAnswer')->middleware('verified');
Route::patch('sts-question-update-answer/{question}', 'SimpleTestSystem\QuestionController@updateAnswer')->middleware('verified');

Route::resource('sts-selected-qsts', 'SimpleTestSystem\SelectedQstsController')->middleware('verified');
Route::resource('sts-shedule', 'SimpleTestSystem\SheduleController')->middleware('verified');

//Route::post('sts-selected-qsts','')->middleware('verified');