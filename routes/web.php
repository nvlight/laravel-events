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

$router->get('/chich', function () use ($router){
    //dump($router);
    return 'marin!';
});

Route::get('/', function () {

    $logined = auth()->id();

    if ($logined !== null){
        return redirect('/event');
    }

    return redirect('/login');
});
//Route::get('/','Auth\LoginController@login');

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

Auth::routes(['verify' => true]);

Route::group([
    'prefix' => 'adverts',
    'as' => 'adverts.',
    'namespace' => 'Adverts',
], function () {
    Route::get('/show/{advert}', 'AdvertController@show')->name('show');
    Route::post('/show/{advert}/phone', 'AdvertController@phone')->name('phone');
    Route::post('/show/{advert}/favorites', 'FavoriteController@add')->name('favorites');
    Route::delete('/show/{advert}/favorites', 'FavoriteController@remove');

    //Route::get('/all/{category?}', 'AdvertController@index')->name('index.all');
    //Route::get('/{region?}/{category?}', 'AdvertController@index')->name('index');
    Route::get('/{adverts_path?}', 'AdvertController@index')->name('index')->where('adverts_path', '.+');
});

Route::get('/login/phone', 'Auth\LoginController@phone')->name('login.phone');
Route::post('/login/phone', 'Auth\LoginController@verify');

Route::resource('category', 'EventCategoryController')->middleware('verified');
Route::resource('type', 'EventTypeController')->middleware('verified');
Route::resource('event', 'EventController')->middleware('verified'); //->name('event');
Route::resource('shorturl', 'ShortUrlController')->middleware('verified');

Route::post('event_copy/{event}','EventController@copyAndPast')->middleware('verified');

Route::get('exchange-rate', 'ExchangeRateController@index')->middleware('verified');
Route::get('exchange-rate-update', 'ExchangeRateController@getLastExchangeRateHtml')->middleware('verified');
Route::get('exchange-rate-test', 'ExchangeRateController@test')->middleware('verified');
Route::get('exchange-rate-test2', 'ExchangeRateController@test2')->middleware('verified');

//Route::get('youtube_watch/{ytVideoId}', 'YouTubeController@watch')->middleware('verified');
//Route::get('youtube_search', 'YouTubeController@search')->middleware('verified');
//Route::post('youtube_search', 'YouTubeController@search')->middleware('verified');
Route::group([
    'prefix' => 'youtube',
    'as' => 'youtube.',
    'middleware' => ['verified'],
], function (){
    Route::get('/','YouTubeController@index')->name('index');
    Route::get('/search_redirect','YouTubeController@search_redirect')->name('search_redirect');
    Route::get('/search','YouTubeController@search')->name('search');
    Route::get('/watch/{ytVideoId}','YouTubeController@watch')->name('watch');
    Route::get('/watch_redirect','YouTubeController@watch_redirect')->name('watch_redirect');
});

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
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');

Route::get('/banner/get', 'BannerController@get')->name('banner.get');
Route::get('/banner/{banner}/click', 'BannerController@click')->name('banner.click');

Route::get('event-filter', 'EventController@filter')->middleware('verified');
Route::get('shorturl-filter', 'ShortUrlController@filter')->middleware('verified');

Route::resource('simple-test-system', 'SimpleTestSystem\CategoryController')
    ->middleware('verified')->middleware('can:admin-panel');

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

Route::get('test_with_1', 'TestController@testwith1')->middleware('verified');
Route::get('test_with_2', 'TestController@testwith2')->middleware('verified')->name('test_with_2');

Route::get('mgram', 'MGram@index');

Route::get('hd_video', 'HDVideoController@index')->middleware('verified'); //

Route::get('/home', 'HomeController@index')->name('home');

//Route::any('/sh555', 'Shelltest@index');

//Route::get('/cabinet', 'Cabinet\HomeController@index')->name('cabinet');
Route::group(
    [
        'prefix' => 'cabinet',
        'as' => 'cabinet.',
        'namespace' => 'Cabinet',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');

//        Route::get('/profile', 'ProfileController@index')->name('profile.home');
//        Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
//        Route::put('/profile/update', 'ProfileController@update')->name('profile.update');

        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/', 'ProfileController@index')->name('home');
            Route::get('/edit', 'ProfileController@edit')->name('edit');
            Route::put('/update', 'ProfileController@update')->name('update');
            Route::post('/phone', 'PhoneController@request');
            Route::get('/phone', 'PhoneController@form')->name('phone');
            Route::put('/phone', 'PhoneController@verify')->name('phone.verify');

            Route::post('/phone/auth', 'PhoneController@auth')->name('phone.auth');
        });

        Route::get('favorites', 'FavoriteController@index')->name('favorites.index');
        Route::delete('favorites/{advert}', 'FavoriteController@remove')->name('favorites.remove');

        Route::group([
            'prefix' => 'adverts',
            'as' => 'adverts.',
            'namespace' => 'Adverts',
            'middleware' => [App\Http\Middleware\FilledProfile::class],
        ], function () {
            Route::get('/', 'AdvertController@index')->name('index');
            Route::get('/create', 'CreateController@category')->name('create');
            Route::get('/create/region/{category}/{region?}', 'CreateController@region')->name('create.region');
            Route::get('/create/advert/{category}/{region?}', 'CreateController@advert')->name('create.advert');
            Route::post('/create/advert/{category}/{region?}', 'CreateController@store')->name('create.advert.store');

            Route::get('/{advert}/edit', 'ManageController@editForm')->name('edit');
            Route::put('/{advert}/edit', 'ManageController@edit');
            Route::get('/{advert}/photos', 'ManageController@photosForm')->name('photos');
            Route::post('/{advert}/photos', 'ManageController@photos');
            Route::get('/{advert}/attributes', 'ManageController@attributesForm')->name('attributes');
            Route::post('/{advert}/attributes', 'ManageController@attributes');
            Route::post('/{advert}/send', 'ManageController@send')->name('send');
            Route::post('/{advert}/close', 'ManageController@close')->name('close');
            Route::delete('/{advert}/destroy', 'ManageController@destroy')->name('destroy');
        });

        Route::group([
            'prefix' => 'banners',
            'as' => 'banners.',
            'namespace' => 'Banners',
            'middleware' => [App\Http\Middleware\FilledProfile::class],
        ], function () {
            Route::get('/', 'BannerController@index')->name('index');
            Route::get('/create', 'CreateController@category')->name('create');
            Route::get('/create/region/{category}/{region?}', 'CreateController@region')->name('create.region');
            Route::get('/create/banner/{category}/{region?}', 'CreateController@banner')->name('create.banner');
            Route::post('/create/banner/{category}/{region?}', 'CreateController@store')->name('create.banner.store');

            Route::get('/show/{banner}', 'BannerController@show')->name('show');
            Route::get('/{banner}/edit', 'BannerController@editForm')->name('edit');
            Route::put('/{banner}/edit', 'BannerController@edit');
            Route::get('/{banner}/file', 'BannerController@fileForm')->name('file');
            Route::put('/{banner}/file', 'BannerController@file');
            Route::post('/{banner}/send', 'BannerController@send')->name('send');
            Route::post('/{banner}/cancel', 'BannerController@cancel')->name('cancel');
            Route::post('/{banner}/order', 'BannerController@order')->name('order');
            Route::delete('/{banner}/destroy', 'BannerController@destroy')->name('destroy');
        });

    }
);

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
        'middleware' => ['auth', 'can:admin-panel'],
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('users', 'UsersController');
        Route::post('/users/{user}/verify', 'UsersController@verify')->name('users.verify');
        Route::post('/users/{user}/unverify', 'UsersController@unverify')->name('users.unverify');

        Route::resource('regions', 'RegionController');

        Route::group(['prefix' => 'adverts', 'as' => 'adverts.', 'namespace' => 'Adverts'], function () {

            Route::resource('categories', 'CategoryController');

            Route::group(['prefix' => 'categories/{category}', 'as' => 'categories.'], function () {
                Route::post('/first', 'CategoryController@first')->name('first');
                Route::post('/up', 'CategoryController@up')->name('up');
                Route::post('/down', 'CategoryController@down')->name('down');
                Route::post('/last', 'CategoryController@last')->name('last');
                Route::resource('attributes', 'AttributeController')->except('index');
            });

            Route::group(['prefix' => 'adverts', 'as' => 'adverts.'], function () {
                Route::get('/', 'AdvertController@index')->name('index');
                Route::get('/{advert}/edit', 'AdvertController@editForm')->name('edit');
                Route::put('/{advert}/edit', 'AdvertController@edit');
                Route::get('/{advert}/photos', 'AdvertController@photosForm')->name('photos');
                Route::post('/{advert}/photos', 'AdvertController@photos');
                Route::get('/{advert}/attributes', 'AdvertController@attributesForm')->name('attributes');
                Route::post('/{advert}/attributes', 'AdvertController@attributes');
                Route::post('/{advert}/moderate', 'AdvertController@moderate')->name('moderate');
                Route::get('/{advert}/reject', 'AdvertController@rejectForm')->name('reject');
                Route::post('/{advert}/reject', 'AdvertController@reject');
                Route::delete('/{advert}/destroy', 'AdvertController@destroy')->name('destroy');
            });

        });

        Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
            Route::get('/', 'BannerController@index')->name('index');
            Route::get('/{banner}/show', 'BannerController@show')->name('show');
            Route::get('/{banner}/edit', 'BannerController@editForm')->name('edit');
            Route::put('/{banner}/edit', 'BannerController@edit');
            Route::post('/{banner}/moderate', 'BannerController@moderate')->name('moderate');
            Route::get('/{banner}/reject', 'BannerController@rejectForm')->name('reject');
            Route::post('/{banner}/reject', 'BannerController@reject');
            Route::post('/{banner}/pay', 'BannerController@pay')->name('pay');
            Route::delete('/{banner}/destroy', 'BannerController@destroy')->name('destroy');
        });
    }
);

Route::group(
    [
        'prefix' => 'cabinet/evento', // url
        'as' => 'cabinet.evento.',    // route_name
        'namespace' => 'Evento',
        'middleware' => ['auth'],
    ], function () {

    Route::group(['prefix' => '/tag', 'as' => 'tag.'], function () {
        Route::get('/', 'TagController@index')->name('index');
        Route::get('/create/', 'TagController@create')->name('create');
        Route::post('/store/', 'TagController@store' )->name('store');
        Route::get('/show/{tag}', 'TagController@show')->name('show');
        Route::get('/edit/{tag}', 'TagController@edit')->name('edit');
        Route::post('/update/{tag}', 'TagController@update')->name('update');
        Route::get('/destroy/{tag}', 'TagController@destroy')->name('destroy');

        Route::post('/store_ajax/', 'TagController@storeAjax' )->name('store_ajax');
        Route::get('/index_ajax/', 'TagController@indexAjax' )->name('index_ajax');
        Route::get('/destroy_ajax/{tag}', 'TagController@destroyAjax')->name('destroy_ajax');
    });

    Route::group(['prefix' => '/category', 'as' => 'category.'], function () {
        Route::get('/', 'CategoryController@index')->name('index');
        Route::get('/create/', 'CategoryController@create')->name('create');
        Route::post('/store/', 'CategoryController@store' )->name('store');
        Route::get('/show/{category}', 'CategoryController@show')->name('show');
        Route::get('/edit/{category}', 'CategoryController@edit')->name('edit');
        Route::post('/update/{category}', 'CategoryController@update')->name('update');
        Route::get('/destroy/{category}', 'CategoryController@destroy')->name('destroy');

        Route::post('/store_ajax/', 'CategoryController@storeAjax' )->name('store_ajax');
        Route::get('/index_ajax/', 'CategoryController@indexAjax' )->name('index_ajax');
        Route::get('/destroy_ajax/{category}', 'CategoryController@destroyAjax')->name('destroy_ajax');
        Route::get('/get_change_category_buttons', 'CategoryController@getChangeCategoryButtonsHtml')->name('get_change_category_buttons');
        Route::post('/edit_category/{category}', 'CategoryController@editCategoryAjax')->name('edit_category');
    });

    Route::group(['prefix' => '/eventotag', 'as' => 'eventotag.'], function () {
        Route::get('/', 'EventoTagController@index')->name('index');
        Route::get('/create/', 'EventoTagController@create')->name('create');
        Route::post('/store/', 'EventoTagController@store' )->name('store');
        Route::get('/show/{eventotag}', 'EventoTagController@show')->name('show');
        Route::get('/edit/{eventotag}', 'EventoTagController@edit')->name('edit');
        Route::post('/update/{eventotag}', 'EventoTagController@update')->name('update');
        Route::get('/destroy/{eventotag}', 'EventoTagController@destroy')->name('destroy');

        Route::post('/store_ajax/', 'EventoTagController@storeAjax' )->name('store_ajax');
        Route::post('/get_user_tags/', 'EventoTagController@getUserTags' )->name('get_user_tags');
        Route::delete('/destroy_ajax/{eventotag}', 'EventoTagController@destroyAjax')->name('destroy_ajax');
    });

    Route::group(['prefix' => '/eventocategory', 'as' => 'eventocategory.'], function () {
        Route::get('/', 'EventoCategoryController@index')->name('index');
        Route::get('/create/', 'EventoCategoryController@create')->name('create');
        Route::post('/store/', 'EventoCategoryController@store' )->name('store');
        Route::get('/show/{eventocategory}', 'EventoCategoryController@show')->name('show');
        Route::get('/edit/{eventocategory}', 'EventoCategoryController@edit')->name('edit');
        Route::post('/update/{eventocategory}', 'EventoCategoryController@update')->name('update');
        Route::get('/destroy/{eventocategory}', 'EventoCategoryController@destroy')->name('destroy');

        // toDo -- remove them after
        Route::get('/destroy_ajax_test/{eventocategory}', 'EventoCategoryController@destroyAjaxTest')->name('destroy_ajax_test');

        Route::post('/get_user_categories/', 'EventoCategoryController@getUserCategories' )->name('get_user_categories');
        Route::post('/store_ajax/', 'EventoCategoryController@storeAjax' )->name('store_ajax');
        Route::delete('/destroy_ajax/{eventocategory}', 'EventoCategoryController@destroyAjax')->name('destroy_ajax');
    });

    Route::group(['prefix' => '/attachment', 'as' => 'attachment.'], function () {
        Route::get('/', 'AttachmentController@index')->name('index');
        Route::get('/create/', 'AttachmentController@create')->name('create');
        Route::post('/store/', 'AttachmentController@store' )->name('store');
        Route::get('/show/{attachment}', 'AttachmentController@show')->name('show');
        Route::get('/edit/{attachment}', 'AttachmentController@edit')->name('edit');
        Route::post('/update/{attachment}', 'AttachmentController@update')->name('update');

        Route::get('/destroyAndRedirect/{attachment}', 'AttachmentController@destroyAndRedirect')->name('destroyAndRedirect');
        Route::get('/destroyAndBack/{attachment}', 'AttachmentController@destroyAndBack')->name('destroyAndBack');
        Route::post('/destroyAjax/{attachment}', 'AttachmentController@destroyAjax')->name('destroyAjax');

        Route::get('/download/{attachment}', 'AttachmentController@download')->name('download');
        Route::post('/store_ajax/', 'AttachmentController@storeAjax' )->name('store_ajax');
        Route::get('/getAttachmentsByEventoId', 'AttachmentController@getAttachmentsByEventoIdAjax')
            ->name('getAttachmentsByEventoId');
    });

    Route::group(['prefix' => '/eventotagvalue', 'as' => 'eventotagvalue.'], function () {
        Route::get('/', 'EventoTagValueController@index')->name('index');
        Route::get('/create/', 'EventoTagValueController@create')->name('create');
        Route::post('/store/', 'EventoTagValueController@store' )->name('store');
        Route::get('/show/{eventoTagValue}', 'EventoTagValueController@show')->name('show');
        Route::get('/edit/{eventoTagValue}', 'EventoTagValueController@edit')->name('edit');
        Route::post('/update/{eventoTagValue}', 'EventoTagValueController@update')->name('update');
        Route::get('/destroy/{eventoTagValue}', 'EventoTagValueController@destroy')->name('destroy');
        Route::get('/download/{eventoTagValue}', 'EventoTagValueController@download')->name('download');
    });

    Route::get('/', 'EventoController@index')->name('index');
    Route::get('/create/', 'EventoController@create')->name('create');
    Route::post('/store/', 'EventoController@store' )->name('store');
    Route::get('/show/{evento}', 'EventoController@show')->name('show');
    Route::get('/edit/{evento}', 'EventoController@edit')->name('edit');
    Route::post('/update/{evento}', 'EventoController@update')->name('update');
    Route::get('/destroy/{evento}', 'EventoController@destroy')->name('destroy');

    Route::post('/store_ajax/', 'EventoController@storeAjax' )->name('store_ajax');
    Route::get('/destroy_ajax/{evento}', 'EventoController@destroyAjax')->name('destroy_ajax');

});

Route::group([
    'prefix' => 'bootstrap5', // prefix for url
    'as' => 'bootstrap5.',    // prefix for names
    'namespace' => 'bootstrap5',
    'middleware' => ['auth'],
], function () {
    Route::get('/', [App\Http\Controllers\Bootstrap5\Bootstrap5::class, 'index'])->name('index');
});