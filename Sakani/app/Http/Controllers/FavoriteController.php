<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoriteRequest;
use App\Services\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct(protected FavoriteService $favoriteService){}
     
    public function toggle(StoreFavoriteRequest $request){
        $validateData = $request->validated();
        $validateData['user_id']=Auth::id();
        $favorite=$this->favoriteService->toggleFavorite($validateData);  
        if(!$favorite){
            
            return $this->result(200,'delete successfully');
        }
        return $this->result(201,"create successfully",$favorite);
    }
    public function index(){
        $userId=Auth::id();
        $userFavorites=$this->favoriteService->index($userId);
        return $this->result(200,'success',$userFavorites);
    }
}
