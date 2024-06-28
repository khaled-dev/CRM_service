<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')->controller(CustomerController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{customer}', 'show');
    Route::put('/{customer}', 'update');
    Route::delete('/{customer}', 'destroy');

    Route::post('/{customer}/comments', 'addComment');
    Route::post('/{customer}/requests', 'addRequest');
});

Route::get('/example', function () {
    return 'Hello, World!';
});
