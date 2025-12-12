<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\RegistroDeAtividades;

class MaterialesEInsumos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'stock',
        'unidad',
        'stock_minimo',
        'proveedor',
        'lote',
        'fecha_vencimiento',
        'responsable_id',
    ];

    public function registros()
    {
        return $this->belongsToMany(RegistroDeAtividades::class, 'registro_actividad_material', 'material_id', 'registro_id')
            ->withPivot(['cantidad_usada', 'unidad'])
            ->withTimestamps();
    }
}
