<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [AuthController::class, 'register']);

// Доступен только с токеном: Authorization: Bearer <token>
Route::get('/profile', ProfileController::class)->middleware('auth:sanctum');
