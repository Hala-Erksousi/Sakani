<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'status',
        'start_date',
        'end_date',
    ];
    public function apartments(){
        return $this->belongsTo(Apartment::class);
    }
    public function user(){
        return $this->belongsTo(Booking::class);
    }
}
