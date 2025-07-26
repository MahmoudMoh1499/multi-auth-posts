<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::prefix(prefix: 'user')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
});

Route::get('/user/{any}', function () {
    return view('app');
})->where('any', '.*');

Route::get('/admin/{any}', function () {
    return view(view: 'app');
})->where('any', '.*');
