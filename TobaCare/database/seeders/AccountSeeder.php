<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            ['id' => Str::uuid(), 'role_id' => 1, 'name' => 'Warga Demo',
             'email' => 'warga@tobacare.test', 'password_hash' => Hash::make('password123'),
             'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'role_id' => 3, 'name' => 'Admin TobaCare',
             'email' => 'admin@tobacare.test', 'password_hash' => Hash::make('password123'),
             'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'role_id' => 2, 'name' => 'Operator Demo',
             'email' => 'operator@tobacare.test', 'password_hash' => Hash::make('password123'),
             'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}