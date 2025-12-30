<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'apartment_id',
        'stars',
    ];

    public function apartment(){
        return $this->belongsTo(Apartment::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function booking(){
        return $this->belongsTo(Booking::class);
    }
}
