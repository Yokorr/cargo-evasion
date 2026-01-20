<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Bike::create(['serial_number' => 'CARB-001', 'model' => 'Triporteur Famille', 'status' => 'available']);
        \App\Models\Bike::create(['serial_number' => 'CARB-002', 'model' => 'Triporteur Famille', 'status' => 'available']);
        \App\Models\Bike::create(['serial_number' => 'CARB-003', 'model' => 'Cargo Pro', 'status' => 'maintenance']);
    }
}
