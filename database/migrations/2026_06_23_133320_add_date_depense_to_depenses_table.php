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
    Schema::table('depenses', function (Blueprint $table) {
        $table->datetime('date_depense')->nullable()->after('montant');
    });
}

public function down(): void
{
    Schema::table('depenses', function (Blueprint $table) {
        $table->dropColumn('date_depense');
    });
}
};
