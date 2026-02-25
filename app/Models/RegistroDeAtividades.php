<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\Organizacion;
use App\Models\Estado;
use App\Models\EquiposYHerramienta;
use App\Models\MaterialesEInsumos;
use App\Models\RegistroActividadMaterial;

class RegistroDeAtividades extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fecha',
        'hora',
        'tipo_actividad',
        'descripcion',
        //'duracion_minutos',
        'hora_inicio',
        'hora_fin',
        'materiales_usados',
        'producto_aplicado',
        'cantidad_producto',
        'unidad',
        'encargado_id',
        'organizacion_id',
        'estado_id',
        'parcela',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_inicio' => 'string',
        'hora_fin' => 'string',
        'cantidad_producto' => 'decimal:2',
        'duracion_minutos' => 'integer',
    ];

    public function encargado()
    {
        return $this->belongsTo(User::class, 'encargado_id');
    }

    public function organizacion()
    {
        return $this->belongsTo(Organizacion::class, 'organizacion_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function equipos()
    {
        return $this->belongsToMany(
            \App\Models\EquiposYHerramienta::class,
            'registro_actividad_equipo',
            'registro_de_atividades_id',
            'equipos_y_herramientas_id'
        )->withTimestamps();
    }

    public function materiales() {
        return $this->belongsToMany(MaterialesEInsumos::class, 
        'registro_actividad_material', 
        'registro_de_atividades_id', 
        'materiales_e_insumos_id')

        ->withPivot(['cantidad', 'unidad_aplicada']) // <--- ESTO ES VITAL
        ->withTimestamps();
    }

    public function materiales_pivote()
    {
        return $this->hasMany(RegistroActividadMaterial::class, 'registro_de_atividades_id');
    }


    

}