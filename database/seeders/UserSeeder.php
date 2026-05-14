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
                'name' => 'Agung Admin',
                'email' => 'admin@smk.com',
                'role' => 'admin',
                'password' => Hash::make('rahasia123'), 
            ],
            [
                'name' => 'Pak Budi Guru',
                'email' => 'guru@smk.com',
                'role' => 'guru',
                'password' => Hash::make('rahasia123'),
            ],
            [
                'name' => 'Intan Aulia',
                'email' => 'siswa@smk.com',
                'role' => 'siswa',
                'password' => Hash::make('rahasia123'),
            ],
        ]);
    }
}