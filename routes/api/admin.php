<?php

use App\Http\Controllers\Admin\Shop\AttributeController;
use App\Http\Controllers\Admin\Shop\BrandController;
use App\Http\Controllers\Admin\Shop\CategoryController;
use App\Http\Controllers\Admin\Shop\ProductController;
use App\Http\Controllers\Admin\Shop\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/shop', [ShopController::class, 'index']);
Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/store', [CategoryController::class, 'store']);
    Route::post('/{category}/update', [CategoryController::class, 'update']);
    Route::delete('/{category}/delete', [CategoryController::class, 'delete']);
});
Route::prefix('/brands')->group(function () {
    Route::get('/', [BrandController::class, 'index']);
    Route::post('/store', [BrandController::class, 'store']);
    Route::post('/{brand}/update', [BrandController::class, 'update']);
    Route::delete('/{brand}/delete', [BrandController::class, 'delete']);
});
Route::prefix('/attributes')->group(function () {
    Route::get('/types', [AttributeController::class, 'types']);
    Route::post('/types/store', [AttributeController::class, 'storeType']);
    Route::post('/types/{type}/update', [AttributeController::class, 'updateType']);

    Route::get('/values', [AttributeController::class, 'values']);
    Route::post('/values/store', [AttributeController::class, 'storeValue']);
    Route::post('/values/{value}/update', [AttributeController::class, 'updateValue']);
});
Route::get('/product/{any_product}', [ProductController::class, 'index']);
Route::post('/product/{any_product}/variation/{any_variation}/update', [ProductController::class, 'updateVariation']);
Route::post('/product/{any_product}/variation/create', [ProductController::class, 'storeVariation']);
Route::post('/product/{any_product}/update', [ProductController::class, 'updateProduct']);
Route::prefix('/product/create')->group(function () {
    Route::post('/upload-image', [ProductController::class, 'uploadImage']);
    Route::post('/slug', [ProductController::class, 'slug']);
    Route::get('/brands', [BrandController::class, 'productBrands']);
    Route::get('/categories', [CategoryController::class, 'productCategories']);
    Route::get('/attributes', [AttributeController::class, 'productTypes']);
    Route::post('/attribute/value', [AttributeController::class, 'ProductAttributes']);
    Route::post('/store', [ProductController::class, 'store']);
});
