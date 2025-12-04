<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService){

        $this->userService = $userService;
       
    }
    public function signUp(StoreUserRequest $request){
        $validateData = $request->validated();
        if($request ->hasFile('image')){
             $path=$request -> file('image')->store('userPhotos','public');
             $validateData['image']=$path;
        }
        $user = $this->userService->createNewUser($validateData);
        return response()->json([
            'code'=>201,
            'message'=>'Create user Successfully',
            'data'=>[
                'User'=>$user
            ]
        ],201);
        
    }
}