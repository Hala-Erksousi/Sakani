<?php

namespace App\Repositories;

use App\Exceptions\TheModelNotFoundException;
use App\Models\Apartment;

class ApartmentRepository
{

    public function createApartment($data)
    {
        return Apartment::create($data);
    }

    public function createApartmentImages(Apartment $apartment, array $imageRecords)
    {
        $apartment->apartment_images()->createMany($imageRecords);
    }

    public function updateApartment($id, array $data)
    {
        $apartment = Apartment::find($id);
        
        $apartment = Apartment::query()->where('id', $id)->first();
        if (!$apartment) {
            throw new TheModelNotFoundException();
        }
        $result = $apartment->update($data);
        return $result;
    }

    public function FindApartmentById($id)
    {
        return Apartment::with(['owner', 'apartment_images'])->find($id);
    }

    public function getAll()
    {
        return Apartment::with('apartment_images')->get();
    }
    public function getAllHome()
    {
        return Apartment::with('mainImage')
        ->select('id', 'price', 'space', 'governorate', 'city')
        ->get();
    }
    
    public function search(){
        $query=Apartment::get();
       
        return $query;
    }
    public function getByOwnerId(int $ownerId)
    {
        return Apartment::where('owner_id', $ownerId)->with('mainImage')->get();
    }

    public function delete(int $id)
    {
        return Apartment::where('id', $id)->delete();
    }

    public function findById(int $id)
    {
        return Apartment::find($id);
    }
}