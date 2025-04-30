<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\RequestController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\SchoolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//schools
Route::get('/schools', [SchoolController::class, 'index']);
Route::get('/schools/{school}', [SchoolController::class, 'show']);

Route::middleware(['auth:sanctum', 'can:access-school'])->group(function () {
    Route::post('/schools/{school}/request', [RequestController::class, 'initiateRequest']);
});

Route::middleware(['auth:sanctum', 'can:access-school'])->group(function () {
    Route::post('/submit-request', [FormController::class, 'submitRequest']);
});

// Devices

Route::get('/devices', [DeviceController::class, 'index']);

Route::middleware(['auth:sanctum', 'can:access-admin'])->group(function () {
    Route::get('/devices/{device}', [DeviceController::class, 'show']);
});

Route::get('schools/{schoolId}/devices', [DeviceController::class, 'getDevicesBySchool']);

Route::middleware(['auth:sanctum', 'can:access-admin'])->group(function () {
    Route::post('/devices', [DeviceController::class, 'store']);
});
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


//Roles and Permissions
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/roles/{id}', [RoleController::class, 'show']);
Route::put('/roles/{id}', [RoleController::class, 'update']);
Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

//Route to  Authorize
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

//profile
Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user()->load('roles');
});