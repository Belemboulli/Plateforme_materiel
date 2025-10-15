<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Cette table peut stocker des statistiques historiques du dashboard
     * ou des rapports mensuels si besoin.
     */
    public function up(): void
    {
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();

            // Exemple de champs pour statistiques historiques
            $table->unsignedInteger('total_materiels')->default(0);
            $table->unsignedInteger('total_categories')->default(0);
            $table->unsignedInteger('total_services')->default(0);

            $table->date('report_date')->nullable(); // pour historique
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboards');
    }
};
