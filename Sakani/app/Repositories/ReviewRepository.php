<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository{
    public function createReview($data){
        return Review::create($data);
    }
}