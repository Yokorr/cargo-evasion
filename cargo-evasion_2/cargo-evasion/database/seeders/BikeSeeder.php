<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Bike::create([
            'serial_number' => 'CARB-001',
            'model' => 'Triporteur Famille',
            'description' => 'Le chouchou des parents à Milly.',
            'status' => 'available',
            'price_morning' => 25,
            'price_afternoon' => 30,
            'price_full_day' => 50,
        ]);
    }
}
