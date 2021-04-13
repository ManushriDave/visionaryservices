<?php

Route::prefix('password')->as('password.')->group(function () {
    Route::get('/forgot', 'PasswordController@request')->name('request');
    Route::post('/forgot', 'PasswordController@email')->name('email');
    Route::get('/reset/{token}', 'PasswordController@reset')->name('reset');
    Route::post('/reset/{token}', 'PasswordController@update')->name('update');
});
