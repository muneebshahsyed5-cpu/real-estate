<?php

use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

Route::get('/owner/properties/index', [OwnerController::class, 'index'])
    ->name('owner.properties.index');

Route::get('/owner/properties/create', [OwnerController::class, 'create'])
    ->name('owner.properties.create');

Route::post('/owner/properties/store', [OwnerController::class, 'store'])
    ->name('owner.properties.store');

Route::get('/owner/properties/{id}/edit', [OwnerController::class, 'edit'])
    ->name('owner.properties.edit');

Route::put('/owner/properties/{id}', [OwnerController::class, 'update'])
    ->name('owner.properties.update');

Route::delete('/owner/properties/{id}', [OwnerController::class, 'destroy'])
    ->name('owner.properties.destroy');

Route::get('/owner/inquiries', [OwnerController::class, 'ownerinquiries'])
    ->name('owner.inquiries');

Route::match(['put', 'post'], '/owner/inquiries/{inquiry}/status', [OwnerController::class, 'ownerinquirystatus'])
    ->name('owner.inquiries.update');

Route::delete(
    '/owner/inquiries/{id}',
    [OwnerController::class, 'ownerinquiriesdestroy']
)->name('owner.inquiries.delete');

Route::post(
    '/owner/inquiries/{id}/reply',
    [OwnerController::class, 'ownerinquiryreply']
)->name('owner.inquiries.reply');
