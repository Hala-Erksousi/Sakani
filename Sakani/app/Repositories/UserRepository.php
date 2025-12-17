<?php
namespace App\Repositories;
use App\Models\User;
class UserRepository{
    
    public function createUser($data)
    {
        return User::create($data);
    }

    public function FindUserById($id)
    {
        return User::find($id);
    }
}