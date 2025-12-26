<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    protected $reviewService;
    public function __construct(ReviewService $reviewService)
    {

        $this->reviewService = $reviewService;
    }

    public function store(StoreReviewRequest $request){
        $validateData = $request->validated();
        $validateData['user_id']=Auth::id();
    }
}
