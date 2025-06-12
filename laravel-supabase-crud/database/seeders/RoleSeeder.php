<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('roles')->count() == 0) {
            DB::table('roles')->insert([
                ['role_id' => 1, 'role_name' => 'Admin'],
                ['role_id' => 2, 'role_name' => 'Doctor'],
                ['role_id' => 3, 'role_name' => 'Patient'],
            ]);
        }
    }
}
