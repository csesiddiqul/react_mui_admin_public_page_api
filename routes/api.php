<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

// create token while register and login
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::post('/forgot-password', [AuthController::class, 'forgot']);

Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.reset');

Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send-otp');
Route::post('/otp-submit', [AuthController::class, 'otpSubmit'])->name('otpSubmit');

//assign to routes //access protected route using jwt token
Route::middleware('auth:sanctum')->group(function (){
    Route::post('/check',[AuthController::class,'check']);
    Route::post('/logout',[AuthController::class,'logout']);

});







