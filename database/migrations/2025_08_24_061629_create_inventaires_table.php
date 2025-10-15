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
        Schema::create('inventaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materiel_id')->constrained('materiels')->onDelete('cascade');
            $table->integer('quantite_disponible')->default(0);
            $table->integer('quantite_utilisee')->default(0);
            $table->integer('quantite_defaillante')->default(0);
            $table->integer('quantite_perdue')->default(0);
            $table->date('date_inventaire');
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index('materiel_id');
            $table->index('date_inventaire');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaires');
    }
};
