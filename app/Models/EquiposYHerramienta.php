<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\RegistroDeAtividades;
use App\Models\User;


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
        return $this->belongsToMany(
            \App\Models\RegistroDeAtividades::class,
            'registro_actividad_equipo',
            'equipos_y_herramientas_id',
            'registro_de_atividades_id'
        )->withTimestamps();
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
