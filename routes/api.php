<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::apiResource('user',UserController::class);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/profile', [AuthController::class, 'profile']);

// Route::middleware('auth:sanctum')->group(function() {
    Route::get('users', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);
// });


