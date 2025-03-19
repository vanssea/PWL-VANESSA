<?php

// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\PenjualanController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\UserController;

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Modifikasi Praktikum 4
Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/tambah', [UserController::class, 'tambah']);
// Jobsheet 4 - Praktikum 2.6 - 
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Jobsheet 4 - Praktikum 2.6 - No 12
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Jobsheet 4 -Praktikum 2.6 - No. 15
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Jobsheet 4 - Praktikum 2.6 - No. 18
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
// Jobsheet 5 - Praktikum 2
Route::get('/kategori', [KategoriController::class, 'index']);
// Jobsheet 5 - Praktikum 3
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store']);
//Tugas Nomer 3 - Menambahkan Edit
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::post('/kategori/{id}/update', [KategoriController::class, 'update'])->name('kategori.update');
Route::resource('kategori', KategoriController::class);




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

