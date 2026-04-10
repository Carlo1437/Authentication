<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MotorRegisterController;
use App\Http\Controllers\MotorRepoController;
use App\Http\Controllers\VehicleRegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::prefix('public')->group(function () {
    Route::apiResource('motor_repo', MotorRepoController::class);
    Route::apiResource('vehicle_registration', VehicleRegistrationController::class);
 });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
   Route::apiResource('users', UserController::class);
   Route::apiResource('motor', MotorRegisterController::class);


});
