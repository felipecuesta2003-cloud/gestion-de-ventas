<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('sales', SaleController::class);