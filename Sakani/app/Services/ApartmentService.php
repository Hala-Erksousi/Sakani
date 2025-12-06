<?php
    namespace App\Services;

use App\Repositories\ApartmentRepository;
use App\Exceptions\TheModelNotFoundException;

    class ApartmentService{
        protected $apartmentRepository;

        public function __construct(ApartmentRepository $apartmentRepository){
            $this->apartmentRepository=$apartmentRepository;
            
        }
        public function createNewApartment(array $data){
             return $user = $this->apartmentRepository->createApartment($data);
        
        }
        public function updateApartment($id,array $data){
            $apartment =$this->apartmentRepository->updateApartment($id,$data);
            // if(!$apartment){
            //     throw new TheModelNotFoundException();
            // }
            return $apartment;
            
        }
    }
