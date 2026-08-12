<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaire_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventaire_id')
                ->constrained('inventaires')
                ->cascadeOnDelete();

            $table->foreignId('produit_id')
                ->constrained('produits')
                ->cascadeOnDelete();

            $table->decimal('stock_theorique', 15, 2)->default(0);

            $table->decimal('stock_compte', 15, 2)->default(0);

            $table->decimal('ecart', 15, 2)->default(0);

            $table->decimal('prix_unitaire', 15, 2)->default(0);

            $table->decimal('valeur_ecart', 15, 2)->default(0);

            $table->enum('type_ecart', [
                'gain',
                'perte',
                'aucun'
            ])->default('aucun');

            $table->timestamps();

            $table->unique([
                'inventaire_id',
                'produit_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaire_details');
    }
};