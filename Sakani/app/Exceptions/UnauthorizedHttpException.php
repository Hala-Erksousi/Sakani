<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UnauthorizedHttpException extends Exception{
    
    public function render(): JsonResponse
    {
        return response()->json([
            'code'=>401,
            'message' => 'unauthorized: Invalid phone or password.'
            ],401);
    }
}