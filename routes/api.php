<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Login
Route::post('/user/login', [App\Http\Controllers\API\UserController::class, 'login']);
Route::post('/user/register', [App\Http\Controllers\API\UserController::class, 'register']);

// User
Route::get('/user', [App\Http\Controllers\API\UserController::class, 'index']);
Route::post('/user/create', [App\Http\Controllers\API\UserController::class, 'store']);
Route::get('/user/{id}', [App\Http\Controllers\API\UserController::class, 'show']);
Route::put('/user/{id}/edit', [App\Http\Controllers\API\UserController::class, 'update']);
Route::delete('/user/{id}', [App\Http\Controllers\API\UserController::class, 'destroy']);

// Hotel
Route::get('/hotel', [App\Http\Controllers\API\HotelController::class, 'index']);
Route::get('/hotel/{id}', [App\Http\Controllers\API\HotelController::class, 'show']);
Route::post('/hotel/create', [App\Http\Controllers\API\HotelController::class, 'store']);
Route::put('/hotel/{id}/edit', [App\Http\Controllers\API\HotelController::class, 'update']);
Route::delete('/hotel/{id}', [App\Http\Controllers\API\HotelController::class, 'destroy']);