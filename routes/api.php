<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\RequestController;
use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\FormController;

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
Route::post('/devices/{id}/assign-name-tag', [DeviceController::class, 'assignNameTag']);