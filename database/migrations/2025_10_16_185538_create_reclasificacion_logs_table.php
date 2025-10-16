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
        Schema::create('reclasificacion_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movimiento_id'); // ID del movimiento reclasificado
            $table->string('usuario', 100); // Usuario que realizó la reclasificación
            $table->string('centro_costo_anterior', 10); // Centro de costo original
            $table->string('centro_costo_nuevo', 10); // Centro de costo destino
            $table->string('seccion_anterior', 255); // Sección original
            $table->string('seccion_nueva', 255); // Sección destino
            $table->string('rubro_anterior', 255); // Rubro original
            $table->string('rubro_nuevo', 255); // Rubro destino
            $table->decimal('valor', 15, 2); // Valor del movimiento
            $table->text('descripcion_movimiento')->nullable(); // Descripción del movimiento
            $table->boolean('revertido')->default(false); // Si fue revertido
            $table->timestamp('fecha_reversion')->nullable(); // Fecha de reversión
            $table->string('usuario_reversion', 100)->nullable(); // Usuario que revirtió
            $table->timestamps(); // created_at y updated_at
            
            // Índices para mejorar búsquedas
            $table->index('movimiento_id');
            $table->index('usuario');
            $table->index('revertido');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclasificacion_logs');
    }
};
