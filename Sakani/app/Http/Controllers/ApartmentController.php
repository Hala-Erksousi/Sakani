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
    
}
