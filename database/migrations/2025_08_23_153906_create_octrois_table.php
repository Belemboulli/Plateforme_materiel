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
        Schema::create('octrois', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers la table materiels
            $table->foreignId('materiel_id')
                  ->constrained('materiels')
                  ->onDelete('cascade');

            // Clé étrangère vers la table structures
            $table->foreignId('structure_id')
                  ->constrained('structures')
                  ->onDelete('cascade');

            // Quantité de matériel octroyée
            $table->integer('quantite');

            // Timestamps created_at et updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('octrois');
    }
};
