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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/logins', [App\Http\Controllers\AuthController::class, 'login'])->middleware('header');
Route::post('/logins', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logouts', [App\Http\Controllers\AuthController::class, 'logout'])->middleware(['header','token']);
Route::post('/authUser', [App\Http\Controllers\UserController::class, 'getAuthUser'])->middleware(['header','token']);