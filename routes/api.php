<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/V1/login', [UserController::class, 'login']);
    Route::post('/V1/add_user', [UserController::class, 'add_user']);
    Route::patch('/V1/update_email/{id}', [UserController::class, 'update_email']);
Route::patch('/V1/update_password/{id}', [UserController::class, 'update_password']);
});


Route::get('/V1/users_by_year', [UserController::class, 'users_by_year']);
Route::get('/V1/users_by_month', [UserController::class, 'users_by_month']);
Route::get('/V1/users_by_week', [UserController::class, 'users_by_week']);
