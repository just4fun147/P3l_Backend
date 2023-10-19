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


// AUTH
Route::post('/logins', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logouts', [App\Http\Controllers\AuthController::class, 'logout'])->middleware(['header','token']);
Route::post('/authUser', [App\Http\Controllers\UserController::class, 'getAuthUser'])->middleware(['header','token']);
Route::post('/editProfile', [App\Http\Controllers\UserController::class, 'editProfile'])->middleware(['header','token']);
Route::post('/register', [App\Http\Controllers\UserController::class, 'register'])->middleware(['header']);
Route::post('/changePassword', [App\Http\Controllers\AuthController::class, 'changePassword'])->middleware(['header']);


// USER
Route::post('/users', [App\Http\Controllers\UserController::class, 'getUser'])->middleware(['header','token']);
Route::post('/users/delete', [App\Http\Controllers\UserController::class, 'delete'])->middleware(['header','token']);
Route::post('/users/edit', [App\Http\Controllers\UserController::class, 'edit'])->middleware(['header','token']);

// Season
Route::post('/seasons', [App\Http\Controllers\SeasonController::class, 'index'])->middleware(['header','token']);
Route::post('/seasons/create', [App\Http\Controllers\SeasonController::class, 'store'])->middleware(['header','token']);
Route::post('/seasons/edit', [App\Http\Controllers\SeasonController::class, 'edit'])->middleware(['header','token']);
Route::post('/seasons/delete', [App\Http\Controllers\SeasonController::class, 'delete'])->middleware(['header','token']);

// Room
Route::post('/rooms', [App\Http\Controllers\RoomController::class, 'index'])->middleware(['header','token']);
Route::post('/rooms/create', [App\Http\Controllers\RoomController::class, 'store'])->middleware(['header','token']);
Route::post('/rooms/edit', [App\Http\Controllers\RoomController::class, 'edit'])->middleware(['header','token']);
Route::post('/rooms/delete', [App\Http\Controllers\RoomController::class, 'delete'])->middleware(['header','token']);

// Room Type
Route::post('/rooms-type', [App\Http\Controllers\RoomController::class, 'indexType'])->middleware(['header','token']);
Route::post('/rooms-type/create', [App\Http\Controllers\RoomController::class, 'storeType'])->middleware(['header','token']);
Route::post('/rooms-type/edit', [App\Http\Controllers\RoomController::class, 'editType'])->middleware(['header','token']);
Route::post('/rooms-type/delete', [App\Http\Controllers\RoomController::class, 'deleteType'])->middleware(['header','token']);

// Coupon
Route::post('/coupons', [App\Http\Controllers\CouponController::class, 'index'])->middleware(['header','token']);
Route::post('/coupons/create', [App\Http\Controllers\CouponController::class, 'store'])->middleware(['header','token']);
Route::post('/coupons/edit', [App\Http\Controllers\CouponController::class, 'edit'])->middleware(['header','token']);
Route::post('/coupons/delete', [App\Http\Controllers\CouponController::class, 'delete'])->middleware(['header','token']);

// Add On
Route::post('/add-on', [App\Http\Controllers\AddonController::class, 'index'])->middleware(['header','token']);
Route::post('/add-on/create', [App\Http\Controllers\AddonController::class, 'store'])->middleware(['header','token']);
Route::post('/add-on/edit', [App\Http\Controllers\AddonController::class, 'edit'])->middleware(['header','token']);
Route::post('/add-on/delete', [App\Http\Controllers\AddonController::class, 'delete'])->middleware(['header','token']);

// Report
Route::post('/report/monthly', [App\Http\Controllers\ReportController::class, 'monthly'])->middleware(['header','token']);
Route::post('/report/getYear', [App\Http\Controllers\ReportController::class, 'getAvailYear'])->middleware(['header','token']);
Route::post('/report/getYearUser', [App\Http\Controllers\ReportController::class, 'getAvailYearUser'])->middleware(['header','token']);
Route::post('/report/guest', [App\Http\Controllers\ReportController::class, 'getGuestPerMonth'])->middleware(['header','token']);
Route::post('/report/new-customer', [App\Http\Controllers\ReportController::class, 'newCust'])->middleware(['header','token']);
Route::post('/report/loyal-customer', [App\Http\Controllers\ReportController::class, 'loyalCustomer'])->middleware(['header','token']);

// Reservation
Route::post('/reservation', [App\Http\Controllers\ReservationController::class, 'index'])->middleware(['header','token']);
Route::post('/reservation/cancel', [App\Http\Controllers\ReservationController::class, 'cancelReservation'])->middleware(['header','token']);


