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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Relations (Clés étrangères)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('bike_id')->constrained()->onDelete('cascade');
            
            // Détails de la location
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->decimal('total_price', 8, 2);
            
            // État du paiement et Caution (Monetico)
            $table->string('payment_status')->default('pending'); // pending, paid, cancelled
            $table->string('monetico_token')->nullable(); // Pour la gestion de la caution
            
            // Lien avec le code du jour
            $table->date('code_date'); 
            $table->foreign('code_date')->references('date_day')->on('daily_codes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
