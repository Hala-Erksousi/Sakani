<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Models\User;

class FavoriteRepository
{

    public function create(array $data)
    {
        return Favorite::create($data);
    }

    public function getUserFavorites($userId)
{
    $user = User::find($userId);

    if (!$user) {
        return [];
    }

    return $user->favoriteApartments()
        ->with('mainImage') 
        ->select('apartments.id', 'price', 'space', 'governorate', 'city') 
        ->get();
}
}
