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
        Schema::table('paiement_achats', function (Blueprint $table) {
            if (!Schema::hasColumn('paiement_achats', 'achat_id')) {
                $table->foreignId('achat_id')->after('id')->constrained('achats')->onDelete('cascade');
            }
            if (!Schema::hasColumn('paiement_achats', 'caisse_id')) {
                $table->foreignId('caisse_id')->after('achat_id')->constrained('caisses')->onDelete('cascade');
            }
            if (!Schema::hasColumn('paiement_achats', 'montant_paye')) {
                $table->decimal('montant_paye', 10, 2)->after('caisse_id');
            }
            if (!Schema::hasColumn('paiement_achats', 'date_paiement')) {
                $table->date('date_paiement')->after('montant_paye');
            }
            if (!Schema::hasColumn('paiement_achats', 'mode')) {
                $table->string('mode')->default('especes')->after('date_paiement');
            }
            if (!Schema::hasColumn('paiement_achats', 'note')) {
                $table->text('note')->nullable()->after('mode');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiement_achats', function (Blueprint $table) {
            $table->dropForeign(['achat_id']);
            $table->dropForeign(['caisse_id']);
            $table->dropColumn(['achat_id', 'caisse_id', 'montant_paye', 'date_paiement', 'mode', 'note']);
        });
    }
};
