<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'user_id',
        'price',
        'rooms',
        'bathrooms',
        'space',
        'floor',
        'description',
        'built_date',
        'title_deed',
        'governorate',
        'city',
        'owner_id'   
    ];

    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
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
