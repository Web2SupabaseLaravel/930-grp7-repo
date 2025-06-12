<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'user_id' => 1,
                'first_name' => 'Mohammad',
                'last_name' => 'Khatib',
                'role_id' => 1, // Admin
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'user_id' => 2,
                'first_name' => 'Alaa',
                'last_name' => 'Qasem',
                'role_id' => 2, // Doctor
                'email' => 'doctor@example.com',
                'password' => Hash::make('doctorpass'),
            ],
        ]);
    }
}
