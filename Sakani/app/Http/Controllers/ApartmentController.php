<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartmentRequest;
use App\Models\Apartment;
use App\services\ApartmentService;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    private $apartmentService;
    public function __construct(ApartmentService $apartmentService){
        $this->apartmentService = $apartmentService;
    }
    public function store(StoreApartmentRequest $request){
     $validateData = $request->validated();
     $apartment = $this->apartmentService->createNewApartment($validateData);
     return $this->result('201','Create apartment Successfully',$apartment);

    }
    public function update(Request $request, $id){
        $rules = [
            'price'       => ['sometimes'],
            'rooms'       => ['sometimes', 'integer', 'min:1'],
            'bathrooms'   => ['sometimes', 'integer', 'min:1'],
            'space'       => ['sometimes', 'numeric'],
            'floor'       => 'sometimes|integer',
            'title_deed'  => 'sometimes|string',
            'governorate' => 'sometimes|string|max:100',
            'city'        => 'sometimes|string|max:100',
        ];
        $validatedData = $request->validate($rules);
        $apartment= $this->apartmentService->updateApartment($id, $validatedData);
        return $this->result('200','update apartment Successfully','');
    }
    
}
