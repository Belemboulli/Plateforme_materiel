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
        Schema::create('structures', function (Blueprint $table) {
            $table->id(); // ID auto-increment
            $table->string('nom'); // Nom obligatoire
            $table->string('type')->nullable(); // Type de structure
            $table->string('responsable')->nullable(); // Responsable
            $table->string('contact', 8)->nullable(); // Contact limité à 8 caractères
            $table->text('description')->nullable(); // Description optionnelle
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structures');
    }
};
