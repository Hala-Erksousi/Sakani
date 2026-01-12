<?php

namespace App\Repositories;


use App\Exceptions\TheModelNotFoundException;
use App\Models\Apartment;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BookingRepository
{

    public function createBooking($data)
    {
        return $booking = Booking::create($data);
    }

    public function getAll($userId)
    {
        return $bookings = Booking::where('user_id', $userId)->get();
    }
    public function getById($id)
    {
        return Booking::with('apartment')->find($id);
    }
    public function showBookingRequests($userId)
    {
        $bookings = Booking::whereHas('apartment', function ($query) use($userId) {
            $query->where('owner_id', '=', $userId);
        })->with(['user'=>function($query){
            $query->select('id','first_name','last_name');
        }])
        ->get();
        return $bookings;
    }
}