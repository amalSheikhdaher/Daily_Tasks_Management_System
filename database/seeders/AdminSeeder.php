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
        $Admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin'
        ]);

        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user1234'),
            'role' => 'user'
        ]);

        $user = User::create([
            'name' => 'user1',
            'email' => 'emilyomar97@gmail.com',
            'password' => Hash::make('123123123'),
            'role' => 'user'
        ]);

        $user = User::create([
            'name' => 'user2',
            'email' => 'amalshekhdaher@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin'
        ]);
    }
}
