<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthenticatedSessionController::class, 'index'])
    ->name('index');

Route::get('/products/get', [ProductController::class, 'get'])->name('product.get');
Route::post('/products/validate', [ProductController::class, 'validate'])->name('product.validate');
Route::resource('products', ProductController::class)
    ->except(['show'])
    ->names([
        'index' => 'product.index',
        'create' => 'product.create',
        'store' => 'product.store',
        'edit' => 'product.edit',
        'update' => 'product.update',
        'destroy' => 'product.destroy'
    ]);

require __DIR__.'/auth.php';
