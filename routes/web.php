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

Route::get('/', function () {

    $logined = auth()->id();

    if ($logined !== null){
        //return view('event.index');
        return redirect('/event');
    }

    return view('welcome');
});

Auth::routes();

Route::resource('category', 'CategoryController')->middleware('verified');
Route::resource('type', 'TypeController')->middleware('verified');
Route::resource('event', 'EventController')->middleware('verified');
Route::resource('shorturl', 'ShortUrlController')->middleware('verified');

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/documents', )

Route::get('exchange-rate', 'ExchangeRateController@index')->middleware('verified');
Route::get('youtube', 'YouTubeController@index')->middleware('verified');
Route::get('document', 'DocumentController@index')->middleware('verified');
Route::get('events-graphics', 'EventController@graphics_index')->middleware('verified');
Route::get('su/{shorturl}', 'ShortUrlController@getShortUrl');

//Route::post('document-load', 'DocumentController@upload')->middleware('verified');
Route::resource('document', 'DocumentController')->middleware('verified');
Route::get('document-download/{document}','DocumentController@download')->middleware('verified');

Route::get('test111', 'TestController@show')->name('tttest.note');
//Route::get('verification.notice', 'TestController@show')->name('tttest.note');

//Route::get('email/verify', 'auth\VerificationController@show')->name('tttest.note');
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');