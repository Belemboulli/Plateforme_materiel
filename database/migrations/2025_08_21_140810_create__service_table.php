<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // ✅ CRÉER la table au lieu de la modifier
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code_service', 10)->nullable();
            $table->text('description')->nullable();
            $table->integer('quantite')->default(0); // Si nécessaire
            $table->enum('statut', ['actif', 'inactif', 'maintenance'])->default('actif');
            $table->enum('priorite', ['haute', 'moyenne', 'basse'])->default('moyenne');
            $table->string('responsable', 100)->nullable();
            $table->string('email_contact')->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('localisation', 150)->nullable();
            $table->timestamps();
            $table->softDeletes(); // Pour deleted_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};
