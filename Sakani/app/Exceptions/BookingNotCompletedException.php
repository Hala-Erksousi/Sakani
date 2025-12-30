<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookingNotCompletedException extends Exception
{
    protected $message = 'Not Found';
    public function render(): JsonResponse
    {
        return response()->json([
            'code' => 404,
            'message' => "You con not review until the booking is Complete"
        ],400);
        
    }
}
