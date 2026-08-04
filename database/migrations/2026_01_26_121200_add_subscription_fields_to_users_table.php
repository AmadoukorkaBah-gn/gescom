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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('admin')->after('email');
            }
            
            if (!Schema::hasColumn('users', 'is_super_admin')) {
                $table->boolean('is_super_admin')->default(false)->after('role');
            }
            
            if (!Schema::hasColumn('users', 'abonnement_type')) {
                $table->enum('abonnement_type', ['mensuel', 'trimestriel', 'annuel', null])->nullable()->after('is_super_admin');
            }
            
            if (!Schema::hasColumn('users', 'date_debut_abonnement')) {
                $table->date('date_debut_abonnement')->nullable()->after('abonnement_type');
            }
            
            if (!Schema::hasColumn('users', 'date_fin_abonnement')) {
                $table->date('date_fin_abonnement')->nullable()->after('date_debut_abonnement');
            }
            
            if (!Schema::hasColumn('users', 'statut_abonnement')) {
                $table->enum('statut_abonnement', ['actif', 'expire', 'suspendu'])->default('actif')->after('date_fin_abonnement');
            }
            
            if (!Schema::hasColumn('users', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->constrained('users')->onDelete('cascade')->after('statut_abonnement');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_super_admin',
                'abonnement_type',
                'date_debut_abonnement',
                'date_fin_abonnement',
                'statut_abonnement',
            ]);
        });
    }
};
