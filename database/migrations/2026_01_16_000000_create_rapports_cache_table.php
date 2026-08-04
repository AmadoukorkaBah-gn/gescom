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
        Schema::create('rapports_cache', function (Blueprint $table) {
            $table->id();
            $table->enum('type_rapport', [
                'ventes_par_periode',
                'produits_plus_vendus',
                'chiffre_affaires',
                'etat_stock',
                'analyse_retours',
                'top_clients'
            ]);
            $table->json('data')->nullable(); // Stocke les données du rapport en JSON
            $table->json('filtres')->nullable(); // Stocke les filtres appliqués (date, produit, etc)
            $table->dateTime('date_generation'); // Quand le rapport a été généré
            $table->dateTime('valide_jusqu'); // Jusqu'à quand ce cache est valide
            $table->timestamps();
            
            // Index pour recherche rapide par type et validité
            $table->index(['type_rapport', 'valide_jusqu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapports_cache');
    }
};
