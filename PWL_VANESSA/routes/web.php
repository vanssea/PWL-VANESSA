<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controller\WelcomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\WelcomeController as ControllersWelcomeController;

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

Route::get('/', [PageController::class, 'index']);
Route::get('/about', [PageController::class, 'about']);

Route::get('/hello', [ControllersWelcomeController::class, 'hello']);

Route::get('/world', function () {
    return 'World!';
});

Route::get('/', function () {
    return 'Selamat Datang';
});

// Route::get('/about', function () {
//     return 'Nama   : Vanessa Cristin Natalia <br> NIM    : 2341720026';
// });

Route::get('/user/{name}', function ($name) {
    return 'Nama saya '.$name;
});

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});

Route::get('/articles/{id}', [PageController::class, 'article']);

// Route::get('/articles/{id}', function ($id) {
//     return 'Halaman Artikel dengan ID ' .$id;
// });

Route::get('/user/{name?}', function ($name='John') {
    return 'Nama saya '.$name;
});

Route::resource('photos', PhotoController::class);

Route::resource('photos', PhotoController::class)->only([ 'index', 'show'
]);

Route::resource('photos', PhotoController::class)->except([ 'create', 'store', 'update', 'destroy'
]);



// Route::get('/user/profile', function () {
//     //
// }) -> name ('profile');

// Route::get (
//     '/user/profile',
//     [UserProfileController::class, 'show']
// ) -> name('profile');

// //Generating URLs...
// $url = route('profile');

// //Generating Redirects...
// return redirect() -> route ('profile');

