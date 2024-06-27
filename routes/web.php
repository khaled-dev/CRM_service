<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $customer = new Customer([
        'name' => 'John Doe',
        'email' => 'john@doe.com',
        'telephone' => '0123456789',
        'address' => '123 Main St',
        'company_name' => 'John Doe',
        'country' => 'egypt',
        'status' => Customer::POTENTIAL,
        'type' => 'LSP',
    ]);


//    dd($customer);

    $customer->save();
    return view('welcome');
});

Route::get('/list', function () {
    $customer = Customer::all()->last();


//    dd($customer);


    return $customer;
});
