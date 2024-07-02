<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OpportunityController;

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

Route::prefix('opportunities')->controller(OpportunityController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{opportunity}', 'show');
    Route::put('/{opportunity}', 'update');
    Route::delete('/{opportunity}', 'destroy');
});

Route::prefix('accounts')->controller(AccountController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{account}', 'show');
    Route::put('/{account}', 'update');
    Route::delete('/{account}', 'destroy');


    Route::prefix('/{account}/contacts')->controller(ContactController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{contact}', 'show');
        Route::put('/{contact}', 'update');
        Route::delete('/{contact}', 'destroy');
    });
});


