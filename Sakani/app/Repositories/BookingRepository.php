<?php

namespace App\Repositories;


use App\Exceptions\TheModelNotFoundException;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BookingRepository
{

public function createBooking($data){
   return $booking = Booking::create($data);
}

public function getAll($userId){
   return $bookings = Booking::where('user_id',$userId)->get();
}
public function getById($id){
    return Booking::find($id);
}
}