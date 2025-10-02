<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoSeccion extends Model
{
    use HasFactory;

    protected $table = 'presupuesto_secciones';

    protected $fillable = [
        'seccion',
        'presupuesto_aprobado',
        'descripcion'
    ];

    protected $casts = [
        'presupuesto_aprobado' => 'decimal:2'
    ];

    // Obtener presupuesto formateado en pesos colombianos
    public function getPresupuestoFormateadoAttribute()
    {
        return '$' . number_format($this->presupuesto_aprobado, 0, ',', '.');
    }

    // Scope para buscar por sección
    public function scopePorSeccion($query, $seccion)
    {
        return $query->where('seccion', $seccion);
    }
}
