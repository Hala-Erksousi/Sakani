<?php

namespace App\Services;

use App\Repositories\ApartmentRepository;
use App\Exceptions\TheModelNotFoundException;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB;

class ApartmentService
{
    protected $apartmentRepository;

    public function __construct(ApartmentRepository $apartmentRepository)
    {
        $this->apartmentRepository = $apartmentRepository;
    }
    public function createNewApartment($data, array $images)
    {
        return DB::transaction(function () use ($data, $images) {
            $apartment = $this->apartmentRepository->createApartment($data);
            if (!empty($images)) {
                $this->processAndAttachImages($apartment, $images);
            }
            return $apartment;
        });
    }

    protected function processAndAttachImages(Apartment $apartment, array $images): void
    {
        $imageRecords = [];
        $isFirstImage = true;

        foreach ($images as $image) {
            $path = $image->store('apartments', 'public');
            $imageRecords[] = [
                'path' => $path,
                'main_photo' => $isFirstImage,
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ];
            $isFirstImage = false;
        }
        $this->apartmentRepository->createApartmentImages($apartment, $imageRecords);
    }
    public function updateApartment($id, array $data)
    {
        $apartment = $this->apartmentRepository->updateApartment($id, $data);
        return $apartment;
    }
    public function getSpecificApartment($id)
    {
        $apartment = $this->apartmentRepository->FindApartmentById($id);
        if (!$apartment) {
            throw new TheModelNotFoundException();
        }
        return $apartment;
    }

    public function getAllApartments(){
        return $this->apartmentRepository->getAll();
    }
    public function getAllApartmentsHome(){
        return  $this->apartmentRepository->getAllHome();
        
    }
    
}
