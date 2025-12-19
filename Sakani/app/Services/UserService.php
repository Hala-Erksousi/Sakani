<?php

namespace App\Services;

use App\Exceptions\TheModelNotFoundException;
use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function createNewUser(array $data)
    {
        return $this->userRepository->createUser($data);
    }

    public function profile($user_id)
    {
        $user =  $this->userRepository->FindUserById($user_id);
        if (!$user) {
            throw new TheModelNotFoundException();
        }
        return $user;
    }
}
