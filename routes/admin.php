<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\BuyerInquiryController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

// Route::get('/admin/properties', [PropertyController::class, 'index'])->name('admin-properties');
// Route::get('/admin/addproperties', [PropertyController::class, 'create'])->name('admin-addproperties');
// Route::post('/admin/properties', [PropertyController::class, 'store'])
//     ->name('admin.properties.store');

Route::resource('properties', PropertyController::class);
Route::get('/admin/featured', [PropertyController::class, 'featured'])
    ->name('admin.featured');
Route::get('/admin/inquiries', [PropertyController::class, 'inquiries'])
    ->name('admin.inquiries');

Route::post(
    '/admin/inquiries/{inquiry}/status',
    [BuyerInquiryController::class, 'updateStatus']
)->name('admin.inquiries.status');
Route::delete(
    '/admin/inquiries/{id}',
    [BuyerInquiryController::class, 'destroy']
)->name('admin.inquiries.delete');
Route::post(
    '/admin/inquiries/{id}/reply',
    [BuyerInquiryController::class, 'reply']
)->name('admin.inquiries.reply');
Route::get('/admin/agents', [PropertyController::class, 'agents'])
    ->name('admin.agents');
Route::get('/admin/agents/{id}', [PropertyController::class, 'agentshow'])
    ->name('admin.agents.show');
Route::get('/admin/agents/{id}/edit', [PropertyController::class, 'agentedit'])
    ->name('admin.agents.edit');

Route::put('/admin/agents/{id}', [PropertyController::class, 'agentupdate'])
    ->name('admin.agents.update');
Route::delete('/admin/agents/{id}', [PropertyController::class, 'agentdelete'])->name('admin.agents.delete');

// Clients//
Route::get('/admin/clients', [PropertyController::class, 'clients'])
    ->name('admin.clients');

Route::get('/admin/clients/{id}', [PropertyController::class, 'clientshow'])
    ->name('admin.clients.show');

Route::get('/admin/client/{id}/edit', [PropertyController::class, 'clientedit'])
    ->name('admin.clients.edit');

Route::put('/admin/client/{id}', [PropertyController::class, 'clientupdate'])
    ->name('admin.client.update');
Route::get('admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile.index');
Route::put('admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
Route::put('admin/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');
//  Namings              URLS                        Methods
// properties.index  ==> properties/            ==> GET
// properties.create ==> properties/create      ==> GET
// properties.store  ==> properties             ==> POST
// properties.destroy ==> ==> properties        ==> DELETE
// properties.update ==> ==> properties/create  ==> PUT/PATCH
