<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookingAlreadyCancelledException extends Exception
{
    protected $message = 'Booking Already Cancelled';
    public function render(): JsonResponse
    {
        return response()->json([
            'code' => 404,
            'message' => $this->getMessage()
        ],404);
    
    }
}
