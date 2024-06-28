<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{customer}', [CustomerController::class, 'show']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::post('/customers/{customer}/comments', [CustomerController::class, 'addComment']);

Route::get('/example', function () {
    return 'Hello, World!';
});
