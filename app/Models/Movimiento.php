<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = [
        'fuente',
        'documento',
        'fecha',
        'cuenta',
        'descripcion',
        'valor',
        'valor_moneda',
        'cliente_proveedor',
        'nombre_cliente_proveedor',
        'tercero',
        'nombre_tercero',
        'auxiliar',
        'centro_costo',
        'vendedor',
        'tipo_doc',
        'doc_factura',
        'vencimiento',
        'referencia',
        'banco',
        'plaza',
        'zona',
        'item',
        'rubro_presupuesto',
        'reserva_presupuestal',
        'usuario',
        'unidad_negocio',
        'unidad1',
        'unidad2',
        'unidad3',
        'c_ocupacion_ciiu',
        'id_moneda_relacion',
        'tasa_cambio_moneda_relacion',
        'valor_moneda_relacion',
        'linea_impuesto',
        'sublinea_impuesto',
        'codigo_propiedad1',
        'codigo_propiedad2',
        'codigo_propiedad3',
        'codigo_propiedad4',
        'codigo_propiedad5',
        'adicional_1',
        'adicional_2',
        'ncf',
        'consecutivo',
    ];

    protected $casts = [
        'fecha' => 'date',
        'vencimiento' => 'date',
        'valor' => 'decimal:2',
        'valor_moneda' => 'decimal:2',
        'tasa_cambio_moneda_relacion' => 'decimal:4',
        'valor_moneda_relacion' => 'decimal:2',
    ];
}
