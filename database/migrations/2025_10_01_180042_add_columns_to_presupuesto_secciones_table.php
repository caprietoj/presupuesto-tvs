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
        Schema::table('presupuesto_secciones', function (Blueprint $table) {
            $table->string('seccion')->unique()->after('id'); // Nombre de la sección
            $table->decimal('presupuesto_aprobado', 15, 2)->default(0)->after('seccion'); // Presupuesto en pesos colombianos
            $table->text('descripcion')->nullable()->after('presupuesto_aprobado'); // Descripción opcional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presupuesto_secciones', function (Blueprint $table) {
            $table->dropColumn(['seccion', 'presupuesto_aprobado', 'descripcion']);
        });
    }
};
