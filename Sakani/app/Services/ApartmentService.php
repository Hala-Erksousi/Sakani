<?php

namespace App\Services;

use App\Repositories\ApartmentRepository;
use App\Exceptions\TheModelNotFoundException;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
    public function search(Request $request)
    {
        $query = $this->apartmentRepository->getAllHome();
        if ($request->filled('governorate')) {
            $query = $query->where('governorate', $request->governorate);
        }
        if ($request->filled('city')) {
            $query = $query->where('city', $request->city);
        }
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query = $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }
        if ($request->filled('min_space') && $request->filled('max_space')) {
            $query = $query->whereBetween('space', [$request->min_space, $request->max_space]);
        }
       
        return $query;
    }
}
