<?php

namespace App\Services;

use App\Repositories\ApartmentRepository;
use App\Exceptions\TheModelNotFoundException;
use Illuminate\Http\Request;


class ApartmentService
{
    protected $apartmentRepository;

    public function __construct(ApartmentRepository $apartmentRepository)
    {
        $this->apartmentRepository = $apartmentRepository;
    }
    public function createNewApartment(array $data)
    {
        return $user = $this->apartmentRepository->createApartment($data);
    }
    public function updateApartment($id, array $data)
    {
        $apartment = $this->apartmentRepository->updateApartment($id, $data);
        // if(!$apartment){
        //     throw new TheModelNotFoundException();
        // }
        return $apartment;
    }

    public function search(Request $request)
    {
        $query = $this->apartmentRepository->search();
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
