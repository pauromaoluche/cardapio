<?php

use App\Livewire\Dashboard\Pages\Auth\AuthForm;
use App\Livewire\Dashboard\Pages\Category\CategoryForm;
use App\Livewire\Dashboard\Pages\Category\CategoryList;
use App\Livewire\Dashboard\Pages\Discount\DiscountForm;
use App\Livewire\Dashboard\Pages\Discount\DiscountList;
use App\Livewire\Dashboard\Pages\Home\Index as IndexHome;
use App\Livewire\Dashboard\Pages\Order\OrderList;
use App\Livewire\Dashboard\Pages\Product\ProductForm;
use App\Livewire\Dashboard\Pages\Product\ProductList;
use App\Livewire\Dashboard\Pages\Promotion\PromotionForm;
use App\Livewire\Dashboard\Pages\Promotion\PromotionList;
use App\Livewire\Web\Pages\Checkout\CheckoutForm;
use App\Livewire\Web\Pages\Home\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', IndexHome::class)->name('index');
    Route::get('/pedidos', OrderList::class)->name('order');

    Route::get('/produtos', ProductList::class)->name('product');
    Route::get('/produtos/adicionar', ProductForm::class)->name('product.create');
    Route::get('/produto/editar/{id}', ProductForm::class)->name('product.edit');

    Route::get('/promocoes', PromotionList::class)->name('promotion');
    Route::get('/promocoes/adicionar', PromotionForm::class)->name('promotion.create');
    Route::get('/promocao/editar/{id}', PromotionForm::class)->name('promotion.edit');

    Route::get('/categorias', CategoryList::class)->name('category');
    Route::get('/categorias/adicionar', CategoryForm::class)->name('category.create');
    Route::get('/categoria/editar/{id}', CategoryForm::class)->name('category.edit');

    Route::get('/descontos', DiscountList::class)->name('discount');
    Route::get('/descontos/adicionar', DiscountForm::class)->name('discount.create');
    Route::get('/desconto/editar/{id}', DiscountForm::class)->name('discount.edit');
});

Route::get('/', Index::class)->name('index');
Route::get('finalizar', CheckoutForm::class)->name('checkout');
Route::get('login', AuthForm::class)->name('login');
