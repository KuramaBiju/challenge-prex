<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GifController;
use Illuminate\Support\Facades\Route;

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


Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'save']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/gif/search/{id}', [GifController::class, 'findById']);
        Route::get('/gif/search', [GifController::class, 'findByPhrase']);
        Route::post('/gif/save', [GifController::class, 'save']);
    });
});
