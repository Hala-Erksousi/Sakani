<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/signUp',UserController::class.'@signUp');
Route::post('/login',AuthController::class.'@login');
