<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bikes', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique(); // Ajouté ici
            $table->string('model');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('available'); // Ajouté ici (available, maintenance, etc.)
            
            // Nos 3 forfaits de prix
            $table->decimal('price_morning', 8, 2)->default(0);
            $table->decimal('price_afternoon', 8, 2)->default(0);
            $table->decimal('price_full_day', 8, 2)->default(0);
            
            $table->timestamps();
        });
    }


    public function down()
    {
        // 1. On désactive la vérification des clés étrangères
        Schema::disableForeignKeyConstraints();

        // 2. On supprime la table
        Schema::dropIfExists('bikes');

        // 3. On les réactive
        Schema::enableForeignKeyConstraints();
    }
};
