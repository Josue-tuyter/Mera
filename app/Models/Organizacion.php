<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organizacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'responsable_id',
        'fecha_inicio',
        'fecha_fin',
        'objetivo',
        'activo',
        'prioridad', // Nuevo
        'status',    // Nuevo
    ];

    // Relaciones
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function estados()
    {
        return $this->hasMany(Estado::class);
    }

    public function registros()
    {
        return $this->hasMany(RegistroDeAtividades::class, 'organizacion_id');
    }
}