<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Relation avec le client 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relation avec le vélo 
            $table->foreignId('bike_id')->constrained()->onDelete('cascade');

            // Dates et heures précises de début et de fin
            $table->dateTime('start_date');
            $table->dateTime('end_date');

            // Prix total calculé au moment de la mise au panier
            $table->decimal('total_price', 8, 2);

            // Référence unique de commande 
            // C'est ce numéro que la banque nous renverra pour valider le paiement
            $table->string('reference')->unique();

            // État de la réservation 
            $table->string('status')->default('pending');

            // État financier 
            // On le passera à 'paid' uniquement après le retour positif de Monetico
            $table->string('payment_status')->default('unpaid');

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
