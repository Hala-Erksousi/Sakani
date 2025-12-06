<?php
namespace App\Repositories;
use App\Models\Apartment;
class ApartmentRepository{
    
    public function createApartment($data)
    {
        return Apartment::create($data);
    }
}