<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['role' => 'ADMIN'],
            ['role' => 'PENGAWAS']
        ]);

        User::create([
            'name' => 'Admin Sikokerja',
            'email' => 'admin@sikokerja.jejakode.com',
            'no_telp' => '081234567890',
            'role' => 'ADMIN',
            'username' => 'admin',
            'password' => Hash::make('admin')
        ]);
    }
}
