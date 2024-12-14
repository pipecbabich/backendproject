<?php

use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoryController::class)->prefix('category')->group(function(){
    Route::get('/list', 'list')->name('api.list.category');
    Route::post('/add', 'create')->name('api.create.category');
    Route::post('/edit/{category}','edit')->name('api.edit.category');
    Route::post('/delete/{category}','destroy')->name('api.delete.category');
});

Route::controller(ProductController::class)->prefix('product')->group(function() {
    Route::get('/list', 'list')->name('api.list.product');
    Route::post('/add', 'create')->name('api.create.product');
    Route::post('/edit/{product}', 'edit')->name('api.edit.product');
    Route::post('/delete/{product}', 'destroy')->name('api.delete.product');
});


