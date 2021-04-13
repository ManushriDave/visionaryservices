<?php

use App\Http\Controllers\NiftyAssistant\CalendarController;
use App\Http\Controllers\NiftyAssistant\ChatController;
use App\Http\Controllers\NiftyAssistant\DashboardController;
use App\Http\Controllers\NiftyAssistant\NiftyGigController;
use App\Http\Controllers\NiftyAssistant\ProfileController;
use App\Http\Controllers\NiftyAssistant\ServiceController;
use App\Http\Controllers\NiftyAssistant\SupportController;
use App\Http\Controllers\NiftyAssistant\TaskController;

Route::middleware(['auth:niftyassistant'])->name('niftyassistant.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::post('/agreement', [DashboardController::class, 'agreement'])->name('agreement.submit');

    Route::prefix('tasks')->as('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/{id}', [TaskController::class, 'show'])->name('show');
        Route::patch('/{id}', [TaskController::class, 'update'])->name('update');
    });

    Route::prefix('support')->as('support.')->group(function () {
        Route::get('/', [SupportController::class, 'index'])->name('index');
        Route::post('/', [SupportController::class,'store'])->name('store');
    });

    Route::prefix('chat')->as('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
    });

    Route::resource('services', ServiceController::class);

    Route::resource('profile', ProfileController::class);

    Route::resource('gigs', NiftyGigController::class);

    Route::prefix('calendar')->name('calendars.')->group(fn () => [
        Route::get('/', [CalendarController::class, 'index'])->name('index'),
        Route::post('/', [CalendarController::class, 'store'])->name('store'),
        Route::delete('/', [CalendarController::class, 'destroy'])->name('destroy'),
    ]);
});
