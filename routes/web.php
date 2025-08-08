<?php

use App\Http\Controllers\Dashboard\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [IndexController::class, 'index'])->name('dashboard');
