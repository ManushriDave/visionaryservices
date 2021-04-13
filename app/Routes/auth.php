<?php

use App\Http\Controllers\Auth\LoginController;

Route::name('auth.')->group(function () {

    /* Login Routes */
    Route::get('/login', 'LoginController@index')->name('login');
    Route::post('/login', 'LoginController@login')->name('login_post');

    /* Registration Routes */
    Route::get('/register', 'RegistrationController@index')->name('register');
    Route::post('/register', 'RegistrationController@register')->name('register_post');
    /* Logout Route */
    Route::middleware('auth')->post('/logout', 'LoginController@logout')->name('logout');
});

Route::get('/email/verify', [LoginController::class, 'email'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [LoginController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [LoginController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
