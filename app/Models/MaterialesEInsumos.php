<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MaterialesEInsumos extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materiales_e_insumos';

    protected $fillable = [
        'nombre', 
        'categoria',
        'tipo',
        'descripcion',
        'stock',
        'unidad',
        'stock_minimo',
        'proveedor',
        'fecha_vencimiento',
        'responsable_id',
    ];

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function registros(): BelongsToMany
    {
        return $this->belongsToMany(RegistroDeAtividades::class, 'registro_actividad_material')
            ->withPivot(['cantidad', 'unidad_aplicada'])
            ->withTimestamps();
    }

    // Accessor para saber si falta stock
    public function getNecesitaReabastecimientoAttribute(): bool
    {
        return $this->stock <= $this->stock_minimo;
    }
}