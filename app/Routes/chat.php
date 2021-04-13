<?php

Route::get('/{id}/{token}', 'ChatController@index')->name('index');
Route::post('/message', 'ChatController@sendMessage');
Route::get('/messages/{id}', 'ChatController@messages')->name('messages');

/*Route::name('chat.')->group(function () {
    Route::get('/{id}', 'ChatController@index')->name('index');
    Route::get('/messages/{id}', 'ChatController@messages')->name('messages');

    Route::post('/message', 'ChatController@storeChat')->name('store');
    Route::post('/room', 'ChatController@storeRoom')->name('room.store');
});*/
