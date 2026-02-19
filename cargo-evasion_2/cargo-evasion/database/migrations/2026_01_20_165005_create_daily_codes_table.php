<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_codes', function (Blueprint $table) {
            $table->id();
            $table->date('date_day')->unique(); // Un seul code par jour
            $table->string('access_code'); // Le code de la boîte à clés
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_codes');
    }
};
