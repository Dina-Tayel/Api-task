<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:api'], function () {

    Route::post('/verified-code', [AuthController::class, 'isVerified']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware(['is.verified'])->group(function () {

        Route::apiResource('tag', TagController::class);

        Route::apiResource('posts', PostController::class);
        Route::post('posts/all-trashed', [PostController::class , 'trashedPosts']);
        Route::post('posts/{id}/restore' , [PostController::class , 'restore']);
        Route::post('posts/restore-all' , [PostController::class , 'restoreAll']);
        Route::post('posts/{id}/force-delete' , [PostController::class , 'forceDelete']);

        Route::post('/stats' , [StatsController::class , 'index']);

    });
});
