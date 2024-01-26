<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\DoctorController;
use App\Http\Controllers\ApiControllers\DonationController;
use App\Http\Controllers\ApiControllers\OrderController;

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

Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login',[AuthController::class,'login']);
Route::post('/auth/register',[AuthController::class,'register']);
Route::get('/auth/logout',[AuthController::class,'logout'])->middleware(['auth:sanctum']);
Route::post('/donate',[DonationController::class,'create'])->middleware(['auth:sanctum']);
Route::post('/order',[OrderController::class,'create'])->middleware(['auth:sanctum']);
Route::post('/doctor/create',[DoctorController::class,'create']);
Route::get('/doctors',[DoctorController::class,'index']);
