<?php

namespace Database\Seeders;

use App\Models\Ubication;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UbicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ubication::create([
            "name" => "CAJONERA"
        ]);

        Ubication::create([
            "name" => "PRIMER PISO"
        ]);
        Ubication::create([
            "name" => "SEGUNDO PISO"
        ]);
        Ubication::create([
            "name" => "CUARTO PISO"
        ]);
        $data = [];

        for ($i = 0; $i < 20; $i++) {
            $cant = $i + 1;
            $locker = "LOCKER {$cant}";
            $data[] = ["name" => $locker];
        }
        Ubication::insert($data);
    }
}
