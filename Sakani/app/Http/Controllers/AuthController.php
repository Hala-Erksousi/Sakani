<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginValidateRequest;
use Illuminate\Http\Request;
use App\Services\AuthServices;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthServices $authService){
       $this->authService = $authService;
    }
    public function login(LoginValidateRequest $request){
        $user = $this->authService->loginService($request);
        return response()->json([
            'code' =>200,
            'message'=>'user login successfully',
            'data'=>[
                'id' => $user['id'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'phone' => $user['phone'],
                'role'=> $user['role'],
                'registration_status'=> $user['registration_status'],
                'token' => $user['token']
            ]
        ],200);
    }
}
