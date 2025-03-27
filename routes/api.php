<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\RequestController;
use App\Http\Controllers\API\FormController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/schools', [SchoolController::class, 'index']);
Route::get('/schools/{school}', [SchoolController::class, 'show']);
Route::post('/schools/{school}/request', [RequestController::class, 'initiateRequest']);
Route::post('/submit-request', [FormController::class, 'submitRequest']);