<?php

namespace App\Services;

use App\Exceptions\BookingAlreadyCancelledException;
use App\Exceptions\NotAvailableDateException;
use App\Repositories\BookingRepository;
use App\Exceptions\TheModelNotFoundException;
use App\Exceptions\TheUnauthorizedActionException;
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

        $apartmentId = $data["apartment_id"];
        $startDate = $data["start_date"];
        $endDate = $data["end_date"];
        $this->checkAvailability($apartmentId, $startDate, $endDate);

        return $booking = $this->bookingRepository->createBooking($data);
    }
    public function checkAvailability($apartmentId, $startDate, $endDate, ?int $ignoreBookingId = null)
    {
        $query = Booking::where('apartment_id', $apartmentId)
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'rejected');

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
        if ($booking->status == 'cancelled') {
            throw new BookingAlreadyCancelledException();
        }
        $booking->update(['status' => 'cancelled']);
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
        if ($booking->status == 'cancelled') {
            throw new BookingAlreadyCancelledException();
        }

        $this->checkAvailability($booking->apartment_id, $startDate, $endDate, $bookingId);
        $booking->update(['start_date' => $startDate, 'end_date' => $endDate]);
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
