<?php

Route::middleware(['auth', 'admin'])->name('admin.')->group(function () {

    /* Dashboard Routes */
    Route::get('/', 'DashboardController@index')->name('index');

    /* Appointments Routes */
    Route::group([
        'as'     => 'appointments.',
        'prefix' => 'appointments',
    ], function () {
        Route::get('/', 'AppointmentController@index')->name('index');
        Route::get('/create', 'AppointmentController@create')->name('create');
        Route::post('/', 'AppointmentController@store')->name('store');
        Route::get('/{id}', 'AppointmentController@show')->name('show');
        Route::patch('/{id}', 'AppointmentController@update')->name('update');
    });

    /* Assistant Type Routes */
    Route::group([
        'as'     => 'assistant_types.',
        'prefix' => 'assistant-types',
    ], function () {
        Route::get('/', 'AssistantTypeController@index')->name('index');
        Route::get('/create', 'AssistantTypeController@create')->name('create');
        Route::post('/', 'AssistantTypeController@store')->name('store');
        Route::get('/{id}', 'AssistantTypeController@show')->name('show');
        Route::get('/edit/{id}', 'AssistantTypeController@edit')->name('edit');
        Route::patch('/update/{id}', 'AssistantTypeController@update')->name('update');
        Route::delete('/{id}', 'AssistantTypeController@destroy')->name('destroy');
    });

    /* Tasks Routes */
    Route::group([
        'as'         => 'tasks.',
        'prefix'     => 'tasks',
    ], function () {
        Route::get('/{id}', 'TaskController@index')->name('index');
        Route::get('/create/{id}', 'TaskController@create')->name('create');
        Route::post('/', 'TaskController@store')->name('store');
        Route::get('/edit/{id}', 'TaskController@edit')->name('edit');
        Route::patch('/update/{id}', 'TaskController@update')->name('update');
        Route::delete('/{id}', 'TaskController@destroy')->name('destroy');
    });

    /* Nifty Assistants Routes */
    Route::group([
        'as'         => 'nifty_assistants.',
        'prefix'     => 'nifty-assistants',
    ], function () {
        Route::get('/', 'NiftyAssistantController@index')->name('index');
        Route::get('/create', 'NiftyAssistantController@create')->name('create');
        Route::get('/{id}', 'NiftyAssistantController@show')->name('show');
        Route::patch('/{id}', 'NiftyAssistantController@update')->name('update');
        Route::delete('/{id}', 'NiftyAssistantController@destroy')->name('destroy');
    });

    /* Ranks Routes */
    Route::resource('nifty-interviews', 'NiftyInterviewController');

    /* Mail Templates Routes */
    Route::resource('mail-templates', 'MailTemplateController');
    Route::get('mail-templates/compose', 'MailTemplateController@compose')->name('mail-templates.compose');
    Route::post('mail-templates/compose', 'MailTemplateController@send')->name('mail-templates.send');

    /* Ranks Routes */
    Route::resource('nifty-ranks', 'NiftyRankController');

    /* Nifty Home Data Routes */
    Route::resource('nifty-home-data', 'NiftyHomeDataController');

    /* Coupon Routes */
    Route::resource('coupons', 'CouponController');

    /* Users Routes */
    Route::group([
        'as'         => 'users.',
        'prefix'     => 'users',
    ], function () {
        Route::get('/', 'UserController@index')->name('index');
        Route::get('/{id}', 'UserController@show')->name('show');
    });

    /* Payment Routes */
    Route::group([
        'as'         => 'payments.',
        'prefix'     => 'payments',
    ], function () {
        Route::get('/', 'PaymentController@index')->name('index');
        Route::get('/{id}', 'PaymentController@show')->name('show');
    });

    Route::post('/download', 'NiftyAssistantController@download')->name('download');

    /* Chat Routes */
    Route::group([
        'as'         => 'chats.',
        'prefix'     => 'chats',
    ], function () {
        Route::get('/', 'ChatController@index')->name('index');
        Route::get('/{id}', 'ChatController@show')->name('show');
    });

    /* Other Tasks Routes */
    Route::group([
        'as'         => 'other-tasks.',
        'prefix'     => 'other-tasks',
    ], function () {
        Route::patch('/{id}', 'OtherTaskController@update')->name('update');
    });

    Route::get('/signatures', 'SignatureController@index')->name('signatures.index');
    Route::post('/signatures/{id}', 'SignatureController@download')->name('signatures.download');
});
