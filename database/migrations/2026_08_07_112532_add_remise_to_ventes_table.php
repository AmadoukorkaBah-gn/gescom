<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            $table->decimal('montant_brut', 15, 2)->nullable()->after('montant_total');
            $table->enum('type_remise', ['fixe', 'pourcentage'])->nullable()->after('montant_brut');
            $table->decimal('valeur_remise', 15, 2)->nullable()->default(0)->after('type_remise');
            $table->decimal('montant_remise', 15, 2)->nullable()->default(0)->after('valeur_remise');
        });
    }

    public function down(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            $table->dropColumn(['montant_brut', 'type_remise', 'valeur_remise', 'montant_remise']);
        });
    }
};