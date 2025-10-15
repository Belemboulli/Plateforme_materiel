<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historique_connexions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(0); // Permet 0 pour les échecs
            $table->string('ip_address', 45);
            $table->text('navigateur')->nullable();
            $table->string('os', 100)->nullable();
            $table->string('etat', 20); // 'succès', 'échec', 'déconnexion'
            $table->timestamp('connecte_le');

            // Index pour améliorer les performances
            $table->index('user_id');
            $table->index('etat');
            $table->index('connecte_le');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historique_connexions');
    }
};
