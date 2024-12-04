<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Engrith',
            'last_name' => 'Rodriguez',
            'email' => 'administracion@consultoriaycapacitacionhseq.com',
            'password' => Hash::make('admin2024*'),
            'activo' => true,
            'is_superuser' => true
        ]);
        User::factory()->create([
            'first_name' => 'Liezelith',
            'last_name' => 'Bustillo',
            'email' => 'ludico@consultoriaycapacitacionhseq.com',
            'password' => Hash::make('ludico2024*'),
            'activo' => true,
            'is_superuser' => false
        ]);
        User::factory()->create([
            'first_name' => 'Brayan',
            'last_name' => 'Castillo',
            'email' => 'coordinador4@consultoriaycapacitacionhseq.com',
            'password' => Hash::make('coordinador42024*'),
            'activo' => true,
            'is_superuser' => false
        ]);
    }
}
