<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('user',UserController::class.'@signUp');

Route::post('apartment',ApartmentController::class.'@store');

Route::put('/apartment/{id}', [ApartmentController::class,'update']);

