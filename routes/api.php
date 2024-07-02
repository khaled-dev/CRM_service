<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CustomerController;

Route::prefix('customers')->controller(CustomerController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{customer}', 'show');
    Route::put('/{customer}', 'update');
    Route::delete('/{customer}', 'destroy');

    Route::post('/{customer}/comments', 'addComment');
    Route::post('/{customer}/requests', 'addRequest');
});

Route::prefix('leads')->controller(LeadController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{lead}', 'show');
    Route::put('/{lead}', 'update');
    Route::delete('/{lead}', 'destroy');

    Route::post('/{lead}/comments', 'addComment');
    Route::post('/{lead}/assign', 'assignUser');
});

