<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RegistroActividadMaterial extends Pivot
{
    protected $table = 'registro_actividad_material';

    protected $fillable = [
        'registro_actividad_id',
        'materiales_e_insumos_id',
        'cantidad',
        'unidad',
    ];
     
}
