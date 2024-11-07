<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Daniel',
            'last_name' => 'Rodriguez',
            'email' => 'daniel@daniel.com',
            'password' => Hash::make('daniel123'),
            'activo' => true,
        ]);
    }
}
