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
        Schema::table('movimientos', function (Blueprint $table) {
            // Índice en fecha para consultas por año y mes
            $table->index('fecha', 'idx_movimientos_fecha');
            
            // Índice en centro_costo para filtros frecuentes
            $table->index('centro_costo', 'idx_movimientos_centro_costo');
            
            // Índice en cuenta para filtros de cuentas contables
            $table->index('cuenta', 'idx_movimientos_cuenta');
            
            // Índice compuesto para consultas que usan fecha + centro_costo
            $table->index(['fecha', 'centro_costo'], 'idx_movimientos_fecha_centro');
            
            // Índice compuesto para consultas que usan fecha + cuenta
            $table->index(['fecha', 'cuenta'], 'idx_movimientos_fecha_cuenta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            // Eliminar índices en orden inverso
            $table->dropIndex('idx_movimientos_fecha_cuenta');
            $table->dropIndex('idx_movimientos_fecha_centro');
            $table->dropIndex('idx_movimientos_cuenta');
            $table->dropIndex('idx_movimientos_centro_costo');
            $table->dropIndex('idx_movimientos_fecha');
        });
    }
};
