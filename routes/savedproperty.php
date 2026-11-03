<?php

use App\Http\Controllers\SavedPropertyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // =========================
    // ADMIN / GENERAL SAVE
    // =========================

    Route::post('/properties/{property}/save',
        [SavedPropertyController::class, 'toggle']
    )->name('properties.save');

    Route::get('/saved-properties',
        [SavedPropertyController::class, 'index']
    )->name('saved-properties.index');


    // =========================
    // USER SAVE
    // =========================

    Route::post('/user/properties/{property}/save',
        [SavedPropertyController::class, 'usertoggle']
    )->name('user.properties.save');

    Route::get('/user/saved-properties',
        [SavedPropertyController::class, 'usersaveindex']
    )->name('user.saved.properties');

});
