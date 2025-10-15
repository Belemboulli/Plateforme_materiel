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
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();

            // =============================================
            // CLÉS ÉTRANGÈRES
            // =============================================

            // Matériel affecté (obligatoire)
            $table->foreignId('materiel_id')
                  ->constrained('materiels')
                  ->onDelete('cascade');

            // Utilisateur bénéficiaire (optionnel)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Service bénéficiaire (optionnel)
            $table->foreignId('service_id')
                  ->nullable()
                  ->constrained('services')
                  ->onDelete('set null');

            // =============================================
            // INFORMATIONS PRINCIPALES
            // =============================================

            // Numéro unique d'affectation
            $table->string('numero_affectation', 50)->unique()->nullable();

            // =============================================
            // DATES
            // =============================================

            // Date de début d'affectation (obligatoire)
            $table->date('date_affectation');

            // Date de retour prévue (optionnelle)
            $table->date('date_retour_prevue')->nullable();

            // Date de retour effective (remplie à la fin)
            $table->date('date_retour')->nullable();

            // =============================================
            // STATUT ET PRIORITÉ
            // =============================================

            // Statut de l'affectation
            $table->enum('statut', ['en cours', 'en attente', 'terminé', 'annulé'])
                  ->default('en cours');

            // Priorité de l'affectation
            $table->enum('priorite', ['faible', 'normale', 'urgente'])
                  ->default('normale');

            // =============================================
            // INFORMATIONS COMPLÉMENTAIRES
            // =============================================

            // Lieu d'utilisation du matériel
            $table->string('lieu_utilisation', 255)->nullable();

            // Responsable ayant validé l'affectation
            $table->string('responsable_validation', 255)->nullable();

            // Commentaires ou notes
            $table->text('commentaire')->nullable();

            // =============================================
            // NOTIFICATIONS ET SUIVI
            // =============================================

            // Indicateur d'envoi de notification
            $table->boolean('notification_envoyee')->default(false);

            // =============================================
            // MÉTADONNÉES (JSON)
            // =============================================

            // Données JSON pour informations supplémentaires
            $table->json('metadata')->nullable();

            // =============================================
            // TIMESTAMPS
            // =============================================

            $table->timestamps();

            // =============================================
            // INDEX POUR OPTIMISATION DES REQUÊTES
            // =============================================

            // Index sur le statut (recherches fréquentes)
            $table->index('statut');

            // Index sur la date d'affectation (tri chronologique)
            $table->index('date_affectation');

            // Index sur la priorité (filtres)
            $table->index('priorite');

            // Index composite pour recherches complexes
            $table->index(['statut', 'date_affectation']);

            // Index sur le numéro d'affectation (recherches)
            $table->index('numero_affectation');

            // Index sur la date de retour prévue (calcul des retards)
            $table->index('date_retour_prevue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};
