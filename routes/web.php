<?php

use App\Livewire\Dashboard\Pages\Home\Index as IndexHome;
use App\Livewire\Dashboard\Pages\Order\OrderList;
use App\Livewire\Dashboard\Pages\Product\ProductForm;
use App\Livewire\Dashboard\Pages\Product\ProductList;
use App\Livewire\Dashboard\Pages\Promotion\PromotionForm;
use App\Livewire\Dashboard\Pages\Promotion\PromotionList;
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

    Route::get('/promocoes', PromotionList::class)->name('promotion');
    Route::get('/promocoes/adicionar', PromotionForm::class)->name('promotion.create');
    Route::get('/promocao/editar/{id}', PromotionForm::class)->name('promotion.edit');
});
