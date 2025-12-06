<?php
    namespace App\Services;

use App\Repositories\ApartmentRepository;

    class ApartmentService{
        protected $apartmentRepository;

        public function __construct(ApartmentRepository $apartmentRepository){
            $this->apartmentRepository=$apartmentRepository;
            
        }
        public function createNewApartment(array $data){
             return $user = $this->apartmentRepository->createApartment($data);
        
        }
    }
