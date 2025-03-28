<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/search', [ProductController::class, 'search']);

Route::get('/products/register', [ProductController::class, 'create']);

Route::post('/products', [ProductController::class, 'store']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::patch('/products/{id}/update', [ProductController::class, 'update']);

Route::delete('/products/{id}/delete', [ProductController::class, 'destroy']);