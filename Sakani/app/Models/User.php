<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Panel;
use Filament\Models\Contracts\HasName;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements HasName
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'email',
        'password',
        'phone',
        'first_name',
        'last_name',
        'personal_photo',
        'date_of_birth',
        'ID_photo',
        'fcm_token',
        'is_verified'
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
            'is_verified' => 'boolean'
        ];
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'owner_id');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function canAccessPanel(Panel $panel)
    {
        return $this->role === 'admin';
    }

    public function getFilamentName(): string
    {
        if ($this->first_name) {
            return trim($this->first_name . ' ' . $this->last_name);
        }
        return $this->email ?? 'Admin';
    }

    protected function personalPhoto(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset(Storage::url($value)) : null,
        );
    }

    protected function idPhoto(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset(Storage::url($value)) : null,
        );
    }
}
