<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $appends=['average_rating'];
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

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function favoritedBy() {
        return $this->belongsToMany(User::class,'favorites', 'user_id', 'apartment_id');
    }

    protected function averageRating(): Attribute
{
    return Attribute::make(
        get: function () {
           
            $avg = $this->reviews()->avg('stars');
            return $avg ? round($avg, 1) : 0;
        },
    );
}

}
