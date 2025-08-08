<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\StatusMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/new_message', [MessageController::class, 'new_message'])->name('new_message');
Route::get('/status_messag', [StatusMessageController::class, 'status_message'])->name('status_message');
