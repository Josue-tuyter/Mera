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

class RegistroDeAtividades extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fecha',
        'hora',
        'tipo_actividad',
        'descripcion',
        'duracion_minutos',
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
        'hora' => 'string',
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
        return $this->belongsToMany(EquiposYHerramienta::class, 'registro_actividad_equipo', 'registro_id', 'equipo_id')
            ->withPivot('nota')
            ->withTimestamps();
    }

    public function materiales()
    {
        return $this->belongsToMany(MaterialesEInsumos::class, 'registro_actividad_material', 'registro_id', 'material_id')
            ->withPivot(['cantidad_usada', 'unidad'])
            ->withTimestamps();
    }
}
