<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroCostoSeccion extends Model
{
    protected $fillable = [
        'centro_costo',
        'rubro', 
        'seccion'
    ];

    protected $table = 'centro_costo_seccions';
}
