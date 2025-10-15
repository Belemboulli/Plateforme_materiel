<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');          // Titre de la notification
            $table->text('message');          // Contenu/message
            $table->string('type')->nullable(); // Exemple : info, warning, success
            $table->boolean('is_read')->default(false); // Notification lue ou non
            $table->timestamps();             // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
