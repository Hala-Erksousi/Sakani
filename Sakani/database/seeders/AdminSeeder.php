<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = 'admin@sakani.com';
        User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => $adminEmail,
            'password' => Hash::make('admin20'), 
            'phone' => '0000000000',
            'role' => 'admin', 
            'is_verified' => true, 
        ]);
    }
}
