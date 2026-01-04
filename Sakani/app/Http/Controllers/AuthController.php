<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginValidateRequest;
use Illuminate\Http\Request;
use App\Services\AuthServices;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ValidateFcmTokenRequest;
use Exception;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthServices $authService)
    {
        $this->authService = $authService;
    }
    public function login(LoginValidateRequest $request)
    {
        $user = $this->authService->loginService($request);

        if (isset($user['code']) && $user['code'] == '403') {
            return $this->result(403, $user['message']);
        }
        return response()->json([
            'code' => 200,
            'message' => 'user login successfully',
            'data' => [
                'id' => $user['id'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'phone' => $user['phone'],
                'token' => $user['token']
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        $this->authService->logoutService($request);
        return response()->json([
            'code' => 200,
            'message' => 'user logged out successfully',
        ], 200);
    }

    public function updateFcmToken(ValidateFcmTokenRequest $request)
    {
        try {
            $fcmTokenData = $request->validated();
            $user = Auth::user();
            $updated = $this->authService->updateFcmTokenService($user->id, $fcmTokenData['fcm_token']);

            if($updated){
                  return $this->result(200, 'FCM Token updated successfully');
            }
        } catch (Exception $e) {
          return $this->result(500, 'An error occurred while updating FCM Token');
        }
    }
}
