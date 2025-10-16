<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReclasificacionLog extends Model
{
    protected $fillable = [
        'movimiento_id',
        'usuario',
        'centro_costo_anterior',
        'centro_costo_nuevo',
        'seccion_anterior',
        'seccion_nueva',
        'rubro_anterior',
        'rubro_nuevo',
        'valor',
        'descripcion_movimiento',
        'revertido',
        'fecha_reversion',
        'usuario_reversion'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'revertido' => 'boolean',
        'fecha_reversion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con el movimiento
     */
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }

    /**
     * Scope para obtener solo reclasificaciones no revertidas
     */
    public function scopeActivas($query)
    {
        return $query->where('revertido', false);
    }

    /**
     * Scope para obtener solo reclasificaciones revertidas
     */
    public function scopeRevertidas($query)
    {
        return $query->where('revertido', true);
    }

    /**
     * Obtener valor formateado
     */
    public function getValorFormateadoAttribute()
    {
        return '$' . number_format($this->valor, 0, ',', '.');
    }
}
