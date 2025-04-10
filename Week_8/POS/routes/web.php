<?php


use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


Route::pattern('id','[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class,'login'])->name('login');
Route::post('login', [AuthController::class,'postlogin']);
Route::get('logout', [AuthController::class,'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('postRegister', [AuthController::class, 'postRegister']);

Route::middleware(['auth'])->group(function(){ // artinya semua route di dalam group ini harus login dulu

    // masukkan semua route yang perlu autentikasi di sini

});


Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
Route::middleware(['authorize:ADM'])->group(function() {
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
});

Route::group(['prefix' => 'level'], function () {
Route::middleware(['authorize:ADM'])->group(function() {
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
});

Route::group(['prefix' => 'kategori'], function() {
Route::middleware(['authorize:ADM,MNG,STF'])->group(function() {
    Route::get('/', [KategoriController::class, 'index']);
    Route::post('/list', [KategoriController::class, 'list']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
     Route::post('/ajax', [KategoriController::class, 'store_ajax']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); 
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
     Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
     Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'supplier'], function () {
Route::middleware(['authorize:ADM,MNG'])->group(function() {
    Route::get('/', [SupplierController::class, 'index']); // menampilkan halaman awal Supplier
    Route::post('/list', [SupplierController::class, 'list']); // menampilkan data Supplier dalam bentuk json untuk datatables
    Route::get('/create', [SupplierController::class, 'create']); // menampilkan halaman form tambah Supplier
    Route::post('/', [SupplierController::class, 'store']); // menyimpan data Supplier baru
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah Supplier Ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Menyimpan data Supplier baru Ajax
    Route::get('/{id}', [SupplierController::class, 'show']); // menampilkan detail Supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit Supplier
    Route::put('/{id}', [SupplierController::class, 'update']); // menyimpan perubahan data Supplier
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // Menampilkan halaman form edit Supplier Ajax
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // Menyimpan perubahan data Supplier Ajax
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Supplier Ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data Supplier Ajax
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data Supplier
    });
});

Route::group(['prefix' => 'barang'], function () {
// Artinya semua route dalam group ini harus punya role ADM (Administrator), MNG (Manager), dan STF (Staff)
Route::middleware(['authorize:ADM,MNG,STF'])->group(function() {
    Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal barang
    Route::post('/list', [BarangController::class, 'list']); // menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah barang
    Route::post('/', [BarangController::class, 'store']); // menyimpan data barang baru
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menyimpan data user baru Ajax
    Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class, 'update']); // menyimpan perubahan data barang
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); //Menampilkan halaman
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); //Menyimpan perubahan
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::get('/import', [BarangController::class, 'import']); // ajax form upload excel
    Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
    Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
    });
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

