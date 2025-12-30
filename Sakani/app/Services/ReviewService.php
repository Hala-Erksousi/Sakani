<?php

namespace App\Services;

use App\Exceptions\BookingNotCompletedException;
use App\Exceptions\TheModelNotFoundException;
use App\Models\Booking;
use App\Repositories\ReviewRepository;

class ReviewService{

    protected $reviewRepository;
    public function __construct(ReviewRepository $reviewRepository)
    {

        $this->reviewRepository = $reviewRepository;
    }
    public function createNewReview($data){
        $booking = Booking::where('id', $data['booking_id'])
        ->where('user_id',$data['user_id'])
        ->first();

        if (!$booking) {
            throw new TheModelNotFoundException();
        }
        if ($booking->status !== 'Completed') {
            throw new BookingNotCompletedException();
        }
        $data['apartment_id']=$booking->apartment_id;
        return $this->reviewRepository->createReview($data);
        
    }
}