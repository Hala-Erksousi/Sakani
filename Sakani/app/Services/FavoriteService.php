<?php

namespace App\Services;

use App\Repositories\FavoriteRepository;
use App\Exceptions\TheModelNotFoundException;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FavoriteService
{ 
    public function __construct(protected FavoriteRepository $favoriteRepository){}
    public function toggleFavorite(array $data){
        $exists = Favorite::where('user_id', $data['user_id'])
                          ->where('apartment_id', $data['apartment_id'])
                          ->first();
       if($exists){
        $exists->delete();
        return ;
       }
       $favorite=$this->favoriteRepository->create($data);
       return $favorite;

    }
    public function index($user){
        return $this->favoriteRepository->getUserFavorites($user);
        
    }


}