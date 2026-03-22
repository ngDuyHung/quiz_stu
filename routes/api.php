<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SchoolClass;

Route::get('/classes', function(Request $request) {
    return SchoolClass::where('faculty_id', $request->faculty_id)->get();
}); 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API users
Route::apiResource('users', UserController::class);

// API load class theo faculty
