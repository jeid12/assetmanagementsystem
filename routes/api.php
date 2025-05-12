<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\RequestController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\SchoolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//schools
Route::get('/schools', [SchoolController::class, 'index']);
Route::get('/schools/{school}', [SchoolController::class, 'show']);


    Route::post('/schools/{school}/request', [RequestController::class, 'initiateRequest']);



    Route::post('/submit-request', [FormController::class, 'submitRequest']);


// Devices

Route::get('/devices', [DeviceController::class, 'index']);

Route::get('/devices/{device}', [DeviceController::class, 'show']);

Route::get('schools/{schoolId}/devices', [DeviceController::class, 'getDevicesBySchool']);

Route::post('/devices', [DeviceController::class, 'store']);

Route::put('/devices/{device}', [DeviceController::class, 'update']);
Route::delete('/devices/{device}', [DeviceController::class, 'destroy']);
//search devices
Route::get('/schools/{id}/devices', [DeviceController::class, 'searchDevice']);
//assign name tag
Route::middleware(['auth:sanctum', 'can:access-admin-rtb-staff'])->group(function () {
    Route::post('/devices/{id}/assign-name-tag', [DeviceController::class, 'assignNameTag']);
    Route::get('/users', [AuthController::class, 'index']);

});
//assign device to school
Route::post('/device/{id}/toschool', [DeviceController::class, 'assignToSchool']);
//all devices

Route::get('/devices/count', [DeviceController::class, 'allDevices']);

//device by category
Route::get('/devices/category/{category}', [DeviceController::class, 'getDevicesByCategory']);

//Roles and Permissions
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/roles/{id}', [RoleController::class, 'show']);
Route::put('/roles/{id}', [RoleController::class, 'update']);
Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

// Register user
Route::post('/register', [AuthController::class, 'register']);

// Step 1: Login and send OTP
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Step 2: Verify OTP and issue token
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');

// Step 3: Logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');

//profile
Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user()->load('roles');
});

//users
Route::get('/users/count', [UserController::class, 'index']);