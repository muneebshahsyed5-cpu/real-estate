<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\BuyerInquiryController;
use Illuminate\Support\Facades\Route;

Route::get('/agent/properties/index', [AgentController::class, 'index'])
    ->name('agent.properties.index');

Route::get('/agent/properties/create', [AgentController::class, 'create'])
    ->name('agent.properties.create');

Route::post('/agent/properties/store', [AgentController::class, 'store'])
    ->name('agent.properties.store');

Route::get('/agent/properties/{id}/edit', [AgentController::class, 'edit'])
    ->name('agent.properties.edit');

Route::put('/agent/properties/{id}', [AgentController::class, 'update'])
    ->name('agent.properties.update');

Route::delete('/agent/properties/{id}', [AgentController::class, 'destroy'])
    ->name('agent.properties.destroy');

    Route::get('/agent/inquiries', [BuyerInquiryController::class, 'agentinquiries'])
    ->name('agent.inquiries');

Route::match(
    ['put', 'post'],
    '/agent/inquiries/{inquiry}/status',
    [BuyerInquiryController::class, 'agentupdateStatus']
)->name('agent.inquiries.status');
Route::delete(
    '/agent/inquiries/{id}',
    [BuyerInquiryController::class, 'agentdestroy']
)->name('agent.inquiries.delete');
Route::post(
    '/agent/inquiries/{id}/reply',
    [BuyerInquiryController::class, 'agentreply']
)->name('agent.inquiries.reply');
