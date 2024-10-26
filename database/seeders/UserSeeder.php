<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'David',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), // Asegúrate de encriptar la contraseña
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
