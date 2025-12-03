<?php
    namespace App\Services;

use App\Repositories\UserRepository;

    class UserService{
        protected $userRepository;

        public function __construct(UserRepository $userRepository){
            $this->userRepository=$userRepository;
            
        }
        public function createNewUser(array $data){
             return $user = $this->userRepository->createUser($data);
        
        }
    }
