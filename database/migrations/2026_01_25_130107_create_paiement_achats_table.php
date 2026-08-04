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
        // Créer la table seulement si elle n'existe pas
        if (!Schema::hasTable('paiement_achats')) {
            Schema::create('paiement_achats', function (Blueprint $table) {
                $table->id();
                $table->foreignId('achat_id')->constrained('achats')->onDelete('cascade');
                $table->foreignId('caisse_id')->constrained('caisses')->onDelete('cascade');
                $table->decimal('montant_paye', 10, 2);
                $table->date('date_paiement');
                $table->string('mode')->default('especes'); // especes, cheque, virement, mobile
                $table->text('note')->nullable();
                $table->timestamps();
            });
        }

        // Ajouter colonnes de suivi paiement sur table achats (si elles n'existent pas)
        if (!Schema::hasColumn('achats', 'montant_paye')) {
            Schema::table('achats', function (Blueprint $table) {
                $table->decimal('montant_paye', 10, 2)->default(0)->after('total');
            });
        }
        
        if (!Schema::hasColumn('achats', 'statut_paiement')) {
            Schema::table('achats', function (Blueprint $table) {
                $table->enum('statut_paiement', ['non_paye', 'partiel', 'paye'])->default('non_paye')->after('statut');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achats', function (Blueprint $table) {
            $table->dropColumn(['montant_paye', 'statut_paiement']);
        });
        Schema::dropIfExists('paiement_achats');
    }
};
