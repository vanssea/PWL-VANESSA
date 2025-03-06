<?php

// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\PenjualanController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\UserController;

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use Illuminate\Support\Facades\Route;

// Modifikasi Praktikum 4
Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', [HomeController::class, 'index']);
// Route::get('/product', [ProductController::class, 'index']);

// Route::prefix('category')->group(callback: function (): void {
//     Route::get('/', [ProductController::class, 'index']);
//     Route::get('/food-beverage', [ProductController::class, 'foodBeverage']);
//     Route::get('/beauty-health', [ProductController::class, 'beautyHealth']);
//     Route::get('/home-care', [ProductController::class, 'homeCare']);
//     Route::get('/baby-kid', [ProductController::class, 'babyKid']);
// });

// Route::get('/user/{id}/name/{name}', [UserController::class, 'index']);
// Route::get('/penjualan', [PenjualanController::class, 'index']);

