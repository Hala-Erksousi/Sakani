<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Models\User;

class AuthRepository
{
    public function updateFcmToken($userId, $fcm_token)
    {
       return User::where('id', $userId)->update([
            'fcm_token' => $fcm_token
        ]);
    }
}
