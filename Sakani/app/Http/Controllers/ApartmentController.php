<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentValidateRequest;
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
     $images = $request->file('images');
     $apartment = $this->apartmentService->createNewApartment($validateData, $images);
     return $this->result(201,'Create apartment Successfully',$apartment);
    }
    public function update(UpdateApartmentValidateRequest $request, $id){
        $validatedData = $request->validated();
        $apartment= $this->apartmentService->updateApartment($id, $validatedData);
        return $this->result(200,'update apartment Successfully');
    }
     public function show($id)
    {
        $apartment = $this->apartmentService->getSpecificApartment($id);
        return $this->result(200,'get apartment successfully',$apartment);
    }

    public function index(){
        $allApartments = $this->apartmentService->getAllApartments();
        return $this->result(200,'Get All Apartments Successfully',$allApartments);
    }

    public function getApartmentHome(){
        $allApartmentsHome = $this->apartmentService->getAllApartmentsHome();
        return $this->result(200,'Get All Apartments Successfully',$allApartmentsHome);
    }
    
    
}
