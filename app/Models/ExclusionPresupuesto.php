<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExclusionPresupuesto extends Model
{
    protected $table = 'exclusiones_presupuesto';
    
    protected $fillable = [
        'movimiento_id',
        'usuario',
        'seccion',
        'rubro',
        'centro_costo',
        'descripcion',
        'valor',
        'fecha_movimiento',
        'documento',
        'motivo',
        'revertido',
        'usuario_reversion',
        'fecha_reversion',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'fecha_movimiento' => 'date',
        'revertido' => 'boolean',
        'fecha_reversion' => 'datetime',
    ];

    /**
     * Relación con el movimiento
     */
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }

    /**
     * Scope para obtener solo exclusiones activas (no revertidas)
     */
    public function scopeActivas($query)
    {
        return $query->where('revertido', false);
    }

    /**
     * Scope para obtener exclusiones revertidas
     */
    public function scopeRevertidas($query)
    {
        return $query->where('revertido', true);
    }

    /**
     * Scope para filtrar por sección
     */
    public function scopePorSeccion($query, $seccion)
    {
        return $query->where('seccion', $seccion);
    }

    /**
     * Verificar si la exclusión puede ser revertida
     */
    public function puedeRevertirse()
    {
        return !$this->revertido;
    }

    /**
     * Marcar como revertida
     */
    public function revertir($usuario)
    {
        $this->revertido = true;
        $this->usuario_reversion = $usuario;
        $this->fecha_reversion = now();
        $this->save();
    }
}
