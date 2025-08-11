<?php

use App\Livewire\Dashboard\Pages\Home\Index as IndexHome;
use App\Livewire\Dashboard\Pages\Order\OrderList;
use App\Livewire\Dashboard\Pages\Product\ProductForm;
use App\Livewire\Dashboard\Pages\Product\ProductList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', IndexHome::class)->name('index');
    Route::get('/pedidos', OrderList::class)->name('order');
    Route::get('/produtos', ProductList::class)->name('product');
    Route::get('/produtos/adicionar', ProductForm::class)->name('product.create');
    Route::get('/produto/editar/{id}', ProductForm::class)->name('product.edit');
});
