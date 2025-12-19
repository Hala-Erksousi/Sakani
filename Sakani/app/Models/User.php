<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Panel;
use Filament\Models\Contracts\HasName;

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
       // 'role',
        'fcm_token',
        'is_verified'
        // 'registration_status'
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
        return $this->hasMany(Apartment::class);
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
        // 1. إذا كان لديك اسم أول (لمستخدم عادي)، قم بعرض الاسم الكامل.
        if ($this->first_name) {
            return trim($this->first_name . ' ' . $this->last_name);
        }
        
        // 2. إذا كان الاسم فارغاً (للمدير)، استخدم الإيميل أو اسم احتياطي ثابت.
        // بما أن الإيميل قد يكون NULL أيضاً حسب الصورة، نفضل الاسم الثابت أو الإيميل مع التحقق.
        return $this->email ?? 'مدير النظام'; 
    }   
}
