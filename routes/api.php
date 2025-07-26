<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\User\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('admin')->group(function () {
    Route::post('/login', action: [AdminAuthController::class, 'login']);

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::apiResource('posts', controller: PostController::class);
    });
});

Route::prefix('user')->group(function () {
    Route::post('/login', [UserAuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [UserAuthController::class, 'logout']);
        Route::put('/posts/{post}', [PostController::class, 'update']);


        Route::apiResource('posts', PostController::class)->except(['index']);
        Route::get('/posts', [PostController::class, 'userPosts']);

        Route::get('/dashboard', action: [DashboardController::class, 'index']);
    });
});


Route::middleware('auth:sanctum')->get('/admin/me', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'email' => $request->user()->email,
        'role' => 'admin'
    ]);
});


Route::middleware('auth:sanctum')->get('/user/me', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'email' => $request->user()->email,
        'role' => 'user'
    ]);
});

