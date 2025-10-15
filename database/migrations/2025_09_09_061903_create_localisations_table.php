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
        Schema::create('localisations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');                  // Nom de la localisation (ex: Salle informatique)
            $table->string('code')->unique();       // Code unique (ex: LOC-001)
            $table->string('batiment')->nullable(); // Nom du bâtiment
            $table->string('etage')->nullable();    // Étage ou niveau
            $table->text('description')->nullable();// Description détaillée
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localisations');
    }
};
