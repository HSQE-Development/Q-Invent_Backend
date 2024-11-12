<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users_for_tests = [
            [
                'first_name' => 'Test',
                'last_name' => 'user',
                'email' => 'test@test.com',
                'password' => Hash::make('password123'),
                'activo' => true,
            ],
            [
                'first_name' => 'TestInactive',
                'last_name' => 'Inactive',
                'email' => 'test_inactive@test.com',
                'password' => Hash::make('password123'),
                'activo' => false,
            ]
        ];
        foreach ($users_for_tests  as $user_for_test) {
            User::factory()->create(
                $user_for_test
            );
        }
    }
}
