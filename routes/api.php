<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::apiResource('user',UserController::class);
Route::post('users', [AuthController::class, 'index']);

Route::apiResource('post',PostController::class);
Route::post('/showPost', [PostController::class, 'showPost']);
Route::post('/uploadCSVFile', [PostController::class, 'uploadCSVFile']);

Route::post('/profile', [AuthController::class, 'profile']);

Route::post('logout', [AuthController::class, 'logout']);

Route::post('/mail', [ContactController::class, 'mail']);

Route::post('/store', [ContactController::class, 'store']);
Route::apiResource('contact',ContactController::class);


Route::group(['middleware' => 'admin'], function () {
    //user
    //contact
});