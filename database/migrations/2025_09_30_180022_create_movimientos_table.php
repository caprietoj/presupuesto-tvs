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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('fuente');
            $table->string('documento');
            $table->date('fecha');
            $table->string('cuenta');
            $table->text('descripcion');
            $table->decimal('valor', 15, 2);
            $table->decimal('valor_moneda', 15, 2);
            $table->string('cliente_proveedor')->nullable();
            $table->string('nombre_cliente_proveedor')->nullable();
            $table->string('tercero')->nullable();
            $table->string('nombre_tercero')->nullable();
            $table->string('auxiliar')->nullable();
            $table->string('centro_costo')->nullable();
            $table->string('vendedor')->nullable();
            $table->string('tipo_doc')->nullable();
            $table->string('doc_factura')->nullable();
            $table->date('vencimiento')->nullable();
            $table->string('referencia')->nullable();
            $table->string('banco')->nullable();
            $table->string('plaza')->nullable();
            $table->string('zona')->nullable();
            $table->string('item')->nullable();
            $table->string('rubro_presupuesto')->nullable();
            $table->string('reserva_presupuestal')->nullable();
            $table->string('usuario')->nullable();
            $table->string('unidad_negocio')->nullable();
            $table->string('unidad1')->nullable();
            $table->string('unidad2')->nullable();
            $table->string('unidad3')->nullable();
            $table->string('c_ocupacion_ciiu')->nullable();
            $table->string('id_moneda_relacion')->nullable();
            $table->decimal('tasa_cambio_moneda_relacion', 10, 4)->nullable();
            $table->decimal('valor_moneda_relacion', 15, 2)->nullable();
            $table->string('linea_impuesto')->nullable();
            $table->string('sublinea_impuesto')->nullable();
            $table->string('codigo_propiedad1')->nullable();
            $table->string('codigo_propiedad2')->nullable();
            $table->string('codigo_propiedad3')->nullable();
            $table->string('codigo_propiedad4')->nullable();
            $table->string('codigo_propiedad5')->nullable();
            $table->string('adicional_1')->nullable();
            $table->string('adicional_2')->nullable();
            $table->string('ncf')->nullable();
            $table->string('consecutivo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
