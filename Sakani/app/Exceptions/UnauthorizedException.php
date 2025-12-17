<?php

namespace App\Exceptions;

namespace App\Exceptions;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class UnauthorizedException extends Exception
{
     public function render(): JsonResponse
    {
        return response()->json([
            'code' => 401,
            'message' => 'Unauthorized.'
        ],401);
    
    }
}
