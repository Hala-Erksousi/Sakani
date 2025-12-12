<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/signUp', [UserController::class, 'signUp']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')
    ->prefix('apartment')
    ->group(function () {
        Route::get('/home', [ApartmentController::class, 'getApartmentHome']);
        Route::get('/filter', [ApartmentController::class, 'search']);

        Route::post('/', [ApartmentController::class, 'store']);
        Route::put('/{apartment_id}', [ApartmentController::class, 'update']);
        Route::get('/{apartment_id}', [ApartmentController::class, 'show']);
        Route::get('/', [ApartmentController::class, 'index']);
    });
