<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu');
            $table->date('date_rapport');

            // Auteur lié à l'utilisateur connecté
            $table->foreignId('auteur_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Checkbox notification (true/false)
            $table->boolean('envoyer_notification')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapports');
    }
};
