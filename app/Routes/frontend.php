<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'verified'])->name('frontend.')->group(function () {

    /* Dashboard Routes */
    Route::get('/', 'DashboardController@index')->name('index');

    /* Bookings Routes */
    Route::prefix('bookings')->as('bookings.')->group(function () {
        Route::get('/', 'BookingController@index')->name('index');
        Route::get('/create', 'BookingController@create')->name('create');
        Route::post('/', 'BookingController@store')->name('store');
        Route::get('/{id}', 'BookingController@show')->name('show');
        Route::get('/{id}/edit', 'BookingController@edit')->name('edit');
        Route::patch('/{id}', 'BookingController@update')->name('update');
        Route::delete('/{id}', 'BookingController@destroy')->name('destroy');
        Route::post('/download', 'BookingController@download')->name('download');
    });

    /* Invoices Routes */
    Route::prefix('invoices')->as('invoices.')->group(function () {
        Route::get('/', 'InvoiceController@index')->name('index');
        Route::get('/{id}', 'InvoiceController@show')->name('show');
    });

    /* Payments Routes */
    Route::prefix('payments')->as('payments.')->group(function () {
        Route::get('/', 'PaymentController@index')->name('index');
    });

    /* Profile Routes */
    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', 'ProfileController@index')->name('index');
        Route::patch('/', 'ProfileController@update')->name('update');
    });

    Route::resource('nifty-wallet', 'NiftyWalletController');
});
