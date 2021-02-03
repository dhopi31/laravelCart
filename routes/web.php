<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/product', [ProductController::class,'index']);
Route::get('/cart', [ProductController::class,'cart']);
Route::get('/cart-live', [ProductController::class,'cartLive']);
Route::get('add-to-cart/{id}', [ProductController::class,'addToCart']);
Route::post('check-out', [ProductController::class, 'checkOut']);
Route::patch('update-cart', [ProductController::class,'update']);
Route::delete('remove-from-cart', [ProductController::class,'remove']);
