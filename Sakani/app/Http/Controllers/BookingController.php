<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateDateBookingRequest;
use App\Http\Requests\UpdateStatusBookingRequest;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;
    public function __construct(BookingService $bookingService)
    {

        $this->bookingService = $bookingService;
    }
    public function store(StoreBookingRequest $request){
        $validateData = $request->validated();
        $validateData['user_id']=Auth::id();
        $booking = $this->bookingService->store($validateData);
        return $this->result('201', 'Create booking Successfully', $booking);

    }
    public function index(){
        $userId=Auth::id();
        $booking = $this->bookingService->getAll($userId);
        return $this->result('200','get Bookings Successfully', $booking);

    }
    public function cancelBookingByUser($booking_id){
          
          $booking= $this->bookingService->cancelBookingByUser($booking_id);
          return $this->result('200','Cancelled Successfully', $booking);
    }
     public function update(UpdateDateBookingRequest $request, $booking_id){
        
         $validateData = $request->validated();
          $booking= $this->bookingService->updateDate($booking_id,$validateData);
          return $this->result('200','Update Successfully', $booking);
     }
}
