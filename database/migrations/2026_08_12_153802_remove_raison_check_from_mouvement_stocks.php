<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            ALTER TABLE mouvement_stocks
            DROP CONSTRAINT IF EXISTS mouvement_stocks_raison_check
        ');
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE mouvement_stocks
            ADD CONSTRAINT mouvement_stocks_raison_check
            CHECK (raison IN ('achat', 'vente', 'retour'))
        ");
    }
};