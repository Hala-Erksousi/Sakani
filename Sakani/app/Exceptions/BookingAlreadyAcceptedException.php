<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookingAlreadyAcceptedException extends Exception
{
    protected $message = 'Booking Already Accepted';
    public function render(): JsonResponse
    {
        return response()->json([
            'code' => 404,
            'message' => $this->getMessage()
        ],404);
    
    }
}
