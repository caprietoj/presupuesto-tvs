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
        Schema::create('centro_costo_seccions', function (Blueprint $table) {
            $table->id();
            $table->string('centro_costo', 10)->unique();
            $table->string('rubro');
            $table->string('seccion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centro_costo_seccions');
    }
};
