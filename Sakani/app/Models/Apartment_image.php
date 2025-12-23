<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Apartment_image extends Model
{
    protected $fillable = [
        'path',
        'main_photo'
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn($value) => asset(Storage::url($value)),
        );
    }
}
