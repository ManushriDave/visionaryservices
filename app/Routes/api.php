<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CurrencyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('json')->group(function () {
    Route::prefix('nifty-assistant')->group(function () {
        Route::get('/{id}', 'NiftyAssistantController@show');
        Route::get('/gig/{id}', 'NiftyAssistantController@gig');
        Route::post('/register', 'NiftyAssistantController@store');
        Route::post('/search', 'NiftyAssistantController@search');
        Route::post('/check', 'NiftyAssistantController@check');
    });

    Route::post('contact', [ContactController::class, 'contact']);

    Route::prefix('assistant-types')->group(function () {
        Route::get('/', 'AssistantTypeController@index');
        Route::get('/{id}', 'AssistantTypeController@show');
        Route::get('/{id}/tasks', 'AssistantTypeController@tasks');
    });

    Route::get('/nifty-home-data', 'NiftyHomeDataController@index');

    Route::post('/login', 'AuthController@login');

    Route::post('/register', 'AuthController@register');

    Route::get('/emirates', 'EmirateController@index');

    Route::get('/nifty-ranks', 'NiftyRankController@index');

    Route::get('/tasks', 'TaskController@index');

    Route::post('/user', 'IndexController@index');

    Route::get('/coupons', [CouponController::class, 'index']);

    Route::post('/coupon/apply', [CouponController::class, 'apply']);

    Route::get('/currencies', [CurrencyController::class, 'index']);

    Route::middleware('auth:api')->post('/room', 'ChatController@storeRoom');

    Route::prefix('chat')->group(function () {
        Route::get('/room/{id}', 'ChatController@getRoom');
        Route::get('/messages/{roomId}', 'ChatController@messages');
        Route::post('/message', 'ChatController@sendMessage');
    });

    Route::middleware('auth:api')->post('/appointment', 'AppointmentController@store');
});
