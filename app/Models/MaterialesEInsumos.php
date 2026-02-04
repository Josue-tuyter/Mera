<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\RegistroActividadMaterial;
use App\Models\RegistroDeAtividades;
use App\Models\User;

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
        return $this->belongsToMany(RegistroDeAtividades::class, 'registro_actividad_material')
            ->using(RegistroActividadMaterial::class)
            ->withPivot(['cantidad', 'unidad_aplicada'])
            ->withTimestamps();
    }


    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
