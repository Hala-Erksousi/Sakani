<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class TheUnauthorizedActionException extends Exception
{
    protected $message = 'You are not authorized to perform this action.';
    public function render(): JsonResponse
    {
        return response()->json([
            'code' => 404,
            'message' => $this->getMessage()
        ],404);
    
    }
}
