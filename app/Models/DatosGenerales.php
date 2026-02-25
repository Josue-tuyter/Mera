<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosGenerales extends Model
{
    protected $table = 'datos_generales';

    protected $fillable = [
        'nombre_finca',
        'propietario',
        'area_hectareas',
        'ubicacion',
        // 'lat',
        // 'lng',
        'tipo_suelo',
        'variedad_cacao',
        // 'altitud_m',
        // 'lluvia_media_mm',
        // 'certificado_organico',
        'contacto_email',
        'telefono',
        'notas',
    ];

    protected $casts = [
        'area_hectareas' => 'decimal:2',
        // 'lat' => 'decimal:7',
        // 'lng' => 'decimal:7',
        // 'altitud_m' => 'integer',
        // 'lluvia_media_mm' => 'decimal:2',
        // 'certificado_organico' => 'boolean',
    ];
}
