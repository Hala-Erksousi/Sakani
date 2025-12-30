<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class InvalidBookingOwnershipException extends Exception
{

    public function render(): JsonResponse
    {
        return response()->json([
            'code' => 403,
            'message' => "the owner cannot book their own property"
        ],403);
        
    }
}
