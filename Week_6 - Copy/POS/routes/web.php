<?php


use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);               // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);           // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);        // menampilkan halaman form tambah user
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); // menyimpan data user baru Ajax
    Route::post('/', [UserController::class, 'store']);              // menyimpan data user baru
    Route::get('/{id}', [UserController::class, 'show']);            // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);       // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);          // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);       // menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);          // menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);       // menampilkan halaman form delete user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);      // menghapus data user Ajax
    Route::delete('/{id}', [UserController::class, 'destroy']);      // menghapus data user
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);               // menampilkan halaman awal user
    Route::post('/list', [LevelController::class, 'list']);           // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);        // menampilkan halaman form tambah user
    Route::post('/', [LevelController::class, 'store']);              // menyimpan data user baru
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    Route::post('/ajax', [LevelController::class, 'store_ajax']);
    Route::get('/{id}', [LevelController::class, 'show']);            // menampilkan detail user
    Route::get('/{id}/edit', [LevelController::class, 'edit']);       // menampilkan halaman form edit user
    Route::put('/{id}', [LevelController::class, 'update']);          // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); 
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::delete('/{id}', [LevelController::class, 'destroy']);      // menghapus data user
});

Route::group(['prefix' => 'kategori'], function() {
    Route::get('/', [KategoriController::class, 'index']);
    Route::post('/list', [KategoriController::class, 'list']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); 
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});

Route::group(['prefix' => 'supplier'], function() {
    Route::get('/', [SupplierController::class, 'index']);
    Route::post('/list', [SupplierController::class, 'list']);
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::get('/{id}', [SupplierController::class, 'show']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']); 
    Route::put('/{id}', [SupplierController::class, 'update']);
    Route::delete('/{id}', [SupplierController::class, 'destroy']);
});

Route::group(['prefix' => 'barang'], function() {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']); 
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\PenjualanController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\UserController;

// use App\Http\Controllers\KategoriController;
// use App\Http\Controllers\LevelController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\WelcomeController;
// use Illuminate\Support\Facades\Route;

// // Modifikasi Praktikum 4
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/tambah', [UserController::class, 'tambah']);
// // Jobsheet 4 - Praktikum 2.6 - 
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// // Jobsheet 4 - Praktikum 2.6 - No 12
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// // Jobsheet 4 -Praktikum 2.6 - No. 15
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// // Jobsheet 4 - Praktikum 2.6 - No. 18
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
// // Jobsheet 5 - Praktikum 2
// Route::get('/', [WelcomeController::class, 'index']);


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

