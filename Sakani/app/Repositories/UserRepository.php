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
        $columns = [ 
        'first_name', 
        'last_name', 
        'personal_photo', 
        'phone',
    ];
        return User::find($id,$columns);
    }
}