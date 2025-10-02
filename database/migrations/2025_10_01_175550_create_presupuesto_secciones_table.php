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
        Schema::create('presupuesto_secciones', function (Blueprint $table) {
            $table->id();
            $table->string('seccion')->unique(); // Nombre de la sección
            $table->decimal('presupuesto_aprobado', 15, 2)->default(0); // Presupuesto en pesos colombianos
            $table->text('descripcion')->nullable(); // Descripción opcional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuesto_secciones');
    }
};
