<?php
namespace App\Repositories;

use App\Exceptions\TheModelNotFoundException;
use App\Models\Apartment;
class ApartmentRepository{
    
    public function createApartment($data)
    {
        return Apartment::create($data);
    }
    public function updateApartment($id, array $data){
        $apartment = Apartment::find($id);

        $apartment= Apartment::query()->where('id', $id)->first();
         if(!$apartment){
            throw new TheModelNotFoundException();
         }
          $result= $apartment->update($data);
          return $result;
         
    }
}