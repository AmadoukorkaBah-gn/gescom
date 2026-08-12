<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaires', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('reference')->unique();

            $table->dateTime('date_inventaire');

            $table->enum('statut', [
                'brouillon',
                'cloture'
            ])->default('brouillon');

            $table->decimal('total_gain', 15, 2)->default(0);

            $table->decimal('total_perte', 15, 2)->default(0);

            $table->dateTime('date_cloture')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaires');
    }
};