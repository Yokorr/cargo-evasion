<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // On crée l'admin
        User::create([
            'name' => 'Admin',
            'email' => 'matthieu.nogueira1609@gmail.com', // Ton email
            'password' => Hash::make('password'), // Ton mot de passe
            'role' => 'admin',
        ]);

        // On appelle le seeder des vélos
        $this->call([
            BikeSeeder::class,
        ]);
    }
}