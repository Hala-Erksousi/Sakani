<?php

namespace App\Services;

use App\Exceptions\BookingAlreadyCancelledException;
use App\Exceptions\InvalidBookingOwnershipException;
use App\Exceptions\NotAvailableDateException;
use App\Repositories\BookingRepository;
use App\Exceptions\TheModelNotFoundException;
use App\Exceptions\TheUnauthorizedActionException;
use App\Exceptions\UnauthorizedException;
use App\Models\Booking;
use App\Repositories\ApartmentRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BookingService
{
    protected $bookingRepository;
    protected $apartmentRepository;

    public function __construct(BookingRepository $bookingRepository, ApartmentRepository $apartmentRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->apartmentRepository = $apartmentRepository;
    }


    public function store(array $data)
    {
        $apartment = $this->apartmentRepository->FindApartmentById($data["apartment_id"]);
        if($apartment->owner_id == $data["user_id"]){
            throw new InvalidBookingOwnershipException();
        }
        $apartmentId = $data["apartment_id"];
        $startDate = $data["start_date"];
        $endDate = $data["end_date"];
        $this->checkAvailability($apartmentId, $startDate, $endDate);
        return $booking = $this->bookingRepository->createBooking($data);
    }


    public function checkAvailability($apartmentId, $startDate, $endDate, ?int $ignoreBookingId = null)
    {
        $query = Booking::where('apartment_id', $apartmentId)
            ->where('status', '!=', 'Cancelled')
            ->where('status', '!=', 'Rejected');

        if ($ignoreBookingId) {
            $query->where('id', '!=', $ignoreBookingId);
        }
        $overlappingDateRanges = $query->where(function ($q) use ($startDate, $endDate) {
            $q->where('end_date', '>=', $startDate)
                ->where('start_date', '<=', $endDate);
        })
            ->exists();
        if ($overlappingDateRanges) {
            throw new NotAvailableDateException();
        }
    }


    public function getAll($userId)
    {
        $bookings = $this->bookingRepository->getAll($userId);
        if ($bookings->isEmpty()) {
            throw new TheModelNotFoundException();
        }
        return $bookings;
    }


    public function cancelBookingByUser($bookingId)
    {
        $booking = $this->bookingRepository->getById($bookingId);
        if (!$booking) {
            throw new TheModelNotFoundException();
        }
        if ($booking->status == 'Cancelled') {
            throw new BookingAlreadyCancelledException();
        }
        $booking->update(['status' => 'Cancelled']);
        return $booking;
    }
    
    public function updateStatueBooking($bookingId,$status,$user_id){
        $booking = $this->bookingRepository->getById($bookingId);
        if (!$booking) {
            throw new TheModelNotFoundException();
        }
        $owner_id=$booking->apartment->owner_id;
        if($owner_id != $user_id){
            throw new UnauthorizedException();
        }
      
        $booking->update(['status' => $status]);
        $booking->makeHidden('apartment');
        return $booking;
    }

    public function updateDate($bookingId, array $data)
    {
        $startDate = $data["start_date"];
        $endDate = $data["end_date"];
        $booking = $this->bookingRepository->getById($bookingId);
        if (!$booking) {
            throw new TheModelNotFoundException();
        }
        if ($booking->user_id != Auth::id()) {
            throw new TheUnauthorizedActionException();
        }
        if ($booking->status == 'Cancelled') {
            throw new BookingAlreadyCancelledException();
        }
        $data['apartment_id']=$booking->apartment_id;
        $this->checkAvailability($booking->apartment_id, $startDate, $endDate, $bookingId);
        $newTotalPrice= $this->calculateBookingPrice($data);
        $booking->update(['start_date' => $startDate, 'end_date' => $endDate,'status'=>'Pending','total_price'=>$newTotalPrice]);
        return $booking;
    }
    public function calculateBookingPrice(array $data)
    {
        $apartment = $this->apartmentRepository->FindApartmentById($data["apartment_id"]);
        $start = Carbon::parse($data["start_date"]);
        $end = Carbon::parse($data["end_date"]);
        $days = $start->diffInDays($end);

        $pricePerDay = $apartment->price / 30; 
        $totalPrice = round($days * $pricePerDay, 2);
        return $totalPrice;
    }
}
