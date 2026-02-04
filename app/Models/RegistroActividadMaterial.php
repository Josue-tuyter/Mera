<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

//class RegistroActividadMaterial extends Pivot
class RegistroActividadMaterial extends Model
{
protected $table = 'registro_actividad_material';

    protected $fillable = [
        'registro_de_atividades_id', // NOMBRE EXACTO DE TU DB (Imagen 4)
        'materiales_e_insumos_id',
        'cantidad',
        'unidad_aplicada',
    ];

    public function material()
    {
        return $this->belongsTo(MaterialesEInsumos::class, 'materiales_e_insumos_id');
    }

}
