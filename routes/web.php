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

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/documents', )

Route::get('exchange-rate', 'ExchangeRateController@index');
Route::get('youtube', 'YouTubeController@index');
Route::get('document', 'DocumentController@index');
Route::get('events-graphics', 'EventController@graphics_index');
