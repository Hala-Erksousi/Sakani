<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'price',
        'rooms',
        'bathrooms',
        'space',
        'floor',
        'title_deed',
        'governorate',
        'city'   
    ];

    public function users(){
        return $this->belongsToMany(User::class,'user_apartment');
    }

     public function booking(){
        return $this->hasMany(Booking::class);
    }

     public function apartment_images ()  {
        return $this->hasMany(Apartment_image::class);
        
    }
    
    public function mainImage(){
        return $this->hasOne(Apartment_image::class)->where('main_photo', true);
    }

}
