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
        Schema::create('exclusiones_presupuesto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movimiento_id'); // ID del movimiento excluido
            $table->string('usuario'); // Usuario que realizó la exclusión
            $table->string('seccion'); // Sección afectada
            $table->string('rubro'); // Rubro del gasto
            $table->string('centro_costo', 10); // Centro de costo
            $table->text('descripcion'); // Descripción del movimiento
            $table->decimal('valor', 15, 2); // Valor del gasto excluido
            $table->date('fecha_movimiento'); // Fecha original del movimiento
            $table->string('documento')->nullable(); // Documento del movimiento
            $table->text('motivo')->nullable(); // Motivo de la exclusión (opcional)
            $table->boolean('revertido')->default(false); // Si fue revertido
            $table->string('usuario_reversion')->nullable(); // Usuario que revirtió
            $table->timestamp('fecha_reversion')->nullable(); // Fecha de reversión
            $table->timestamps();
            
            // Índices para mejorar búsquedas
            $table->index('movimiento_id');
            $table->index('seccion');
            $table->index('revertido');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exclusiones_presupuesto');
    }
};
