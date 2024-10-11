<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/V1/login', [UserController::class, 'login']);
Route::post('/V1/add_user', [UserController::class, 'add_user']);