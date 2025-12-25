<?php

namespace App\Exceptions;
use Illuminate\Http\JsonResponse;



use Exception;

class NotAvailableDateException extends Exception
{
    
    
        public function render(): JsonResponse
        {
            return response()->json([
                'code'=>422,
                'message' => 'The apartment is already booked for some or all of the requested dates.'
                ],422);
        }
    
}
