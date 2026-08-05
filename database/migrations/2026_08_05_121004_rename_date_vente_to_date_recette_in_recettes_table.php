<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('recettes', function (Blueprint $table) {
        $table->dropColumn('date_vente');
    });
}


public function down()
{
    Schema::table('recettes', function (Blueprint $table) {
        $table->dateTime('date_vente')->nullable();
    });
}
};