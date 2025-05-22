<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserResponseController;
use App\Http\Controllers\WordController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/daily-word', [WordController::class, 'dailyWord']);
    Route::get('/search', [WordController::class, 'searchWords']);
    Route::post('/answer', [UserResponseController::class, 'store']);
    Route::get('/histories', [HistoryController::class, 'index']);
    Route::get('/histories/stats', [HistoryController::class, 'getUserActivity']);
});
