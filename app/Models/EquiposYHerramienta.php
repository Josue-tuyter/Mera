<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\RegistroDeAtividades;

class EquiposYHerramienta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'serial',
        'disponible',
        'fecha_ultimo_mantenimiento',
        'proximo_mantenimiento',
        'intervalo_mantenimiento_dias',
        'ubicacion',
        'responsable_id',
        'costo_mantenimiento_estimado',
    ];

    public function registros()
    {
        return $this->belongsToMany(RegistroDeAtividades::class, 'registro_actividad_equipo', 'equipo_id', 'registro_id')
            ->withPivot(['nota'])
            ->withTimestamps();
    }
}
