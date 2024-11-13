<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Ernie Dipko',
            'email' => 'ernie.dipko@gmail.com',
            'password' => Hash::make('Password123'),
        ]);
    }
}
