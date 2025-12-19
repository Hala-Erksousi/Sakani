<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'password',
        'phone',
        'first_name',
        'last_name',
        'personal_photo',
        'date_of_birth',
        'ID_photo',
       // 'role',
        'fcm_token',
        'registration_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
