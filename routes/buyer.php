<?php

// use App\Http\Controllers\BuyerInquiryController;
// use Illuminate\Routing\Route;
// use Illuminate\Support\Facades\Route as FacadesRoute;


use App\Http\Controllers\BuyerInquiryController;
use App\Http\Controllers\RecentlyviewController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('buyer')->name('buyer.')->group(function () {

    Route::get('/properties', [BuyerInquiryController::class, 'index'])->name('properties');

    Route::get('/inquiries', [BuyerInquiryController::class, 'inquiresindex'])
        ->name('inquiries.index');

    Route::get('/properties/{property}/inquiry', [BuyerInquiryController::class, 'create'])
        ->name('inquiries.create');


    Route::post('/properties/{property?}/inquiry', [BuyerInquiryController::class, 'store'])
        ->name('inquiries.store');

    Route::get('/properties/{property}/detailed', [BuyerInquiryController::class, 'show'])
        ->name('properties.detailed');

         Route::get('/properties/recently-viewed',
        [RecentlyviewController::class, 'index']
    )->name('properties.recently-viewed');
});
