<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun admin otomatis saat db di-seed
        User::create([
            'name' => 'Admin UNotify',
            'email' => 'Hamhamroin@gmail.com',
            'password' => Hash::make('087850084270roin'), // Passwordnya nanti: password123
            'role' => 'admin',
        ]);
    }
}