<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Organizacion;
use App\Models\RegistroDeAtividades;

class Estado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'porcentaje_avance',
        'color',
        'organizacion_id',
    ];

    public function organizacion()
    {
        return $this->belongsTo(Organizacion::class);
    }

    public function registros()
    {
        return $this->hasMany(RegistroDeAtividades::class, 'estado_id');
    }
}
