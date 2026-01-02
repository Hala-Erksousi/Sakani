<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;

Route::post('/signUp', [UserController::class, 'signUp']);
Route::post('/login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')
  ->group(function () {

    Route::prefix('apartment')
      ->group(function () {
        Route::get('/home', [ApartmentController::class, 'getApartmentHome']);
        Route::get('/filter', [ApartmentController::class, 'search']);
        Route::post('/', [ApartmentController::class, 'store']);
        Route::put('/{apartment_id}', [ApartmentController::class, 'update']);
        Route::get('/{apartment_id}', [ApartmentController::class, 'show']);
        Route::get('/', [ApartmentController::class, 'index']);
      });

    Route::prefix('booking')
      ->group(function () {
        Route::get('/calculate', [BookingController::class, 'calculateBookingPrice']);
        Route::post('/', [BookingController::class, 'store']);
        Route::get('/', [BookingController::class, 'index']);
        Route::put('/{booking_id}/cancel', [BookingController::class, 'cancelBookingByUser']);
        Route::put('/{bookingId}/reject', [BookingController::class, 'rejectBooking']);
        Route::put('/{bookingId}/accept', [BookingController::class, 'acceptBooking']);
        Route::put('/{booking_id}/update', [BookingController::class, 'update']);
      });

    Route::prefix('review')
      ->group(function () {
        Route::post('/', [ReviewController::class, 'store']);
      });

    Route::prefix('notifications')
      ->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread', [NotificationController::class, 'unreadCount']);
        Route::post('/{notification_id}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead']);
      });

    Route::prefix('favorite')
    ->group(function () {
      Route::post('/', [FavoriteController::class, 'toggle']);
      Route::get('/', [FavoriteController::class, 'index']);
    });
  });

    
Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::get('/profile', [UserController::class, 'profile']);
});
