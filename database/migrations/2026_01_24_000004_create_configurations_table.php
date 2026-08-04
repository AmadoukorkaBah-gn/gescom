<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Informations entreprise
            $table->string('nom_entreprise')->nullable();
            $table->string('logo')->nullable(); // Chemin du fichier logo
            $table->string('contact')->nullable();
            $table->string('email_entreprise')->nullable();
            $table->text('adresse')->nullable();
            
            // Devise
            $table->string('devise', 10)->default('GNF');
            $table->string('symbole_devise', 5)->default('GNF');
            
            // Couleurs personnalisées
            $table->string('couleur_primaire', 20)->default('#1e293b');
            $table->string('couleur_secondaire', 20)->default('#3b82f6');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
