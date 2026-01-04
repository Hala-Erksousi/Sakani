<?php

namespace App\Services;

use App\Exceptions\BadRequestHttpException;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UnauthorizedHttpException;
use App\Exceptions\ValidationException;
use App\Exceptions\UnauthorizedException;
use App\Repositories\AuthRepository;

class AuthServices
{
    protected $authRepository;
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function loginService($request)
    {
        try {
            $request->validated();
            if (!Auth::attempt($request->only('phone', 'password'))) {
                throw new UnauthorizedHttpException();
            }
            $user = $request->user();
            if (!$user->is_verified) {
                return [
                    'code' => '403',
                    'message' => 'Your account is pending verification by the admin Please wait.'
                ];
            }
            $user->tokens()->delete();
            $token = $user->createToken('access_token')->plainTextToken;
        } catch (ValidationException $e) {
            throw new ValidationException($e);
        } catch (BadRequestHttpException $e) {
            throw new BadRequestHttpException();
        }
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'token' => $token
        ];
    }

    public function logoutService($request){
        $user = $request->user();
        $user->tokens()->delete();
         if (!$request->user()) {
            throw new UnauthorizedException();
        }
        $request->user()->currentAccessToken()->delete();
    }

    public function updateFcmTokenService($userId, $fcm_token)
    {
        return $this->authRepository->updateFcmToken($userId, $fcm_token);
    }
}
