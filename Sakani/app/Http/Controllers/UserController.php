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
    public function __construct(UserService $userService)
    {

        $this->userService = $userService;
    }
    public function signUp(StoreUserRequest $request)
    {
        $validateData = $request->validated();
        if($request ->hasFile('personal_photo')){
             $path=$request->file('personal_photo')->store('user_photos/personal','public');
             $validateData['personal_photo']=$path;
        }
        if($request ->hasFile('ID_photo')){
             $path=$request->file('ID_photo')->store('user_photos/ID','public');
             $validateData['ID_photo']=$path;
        }
        $user = $this->userService->createNewUser($validateData);
        return $this->result('201', 'Create user Successfully', $user);
    }
}
