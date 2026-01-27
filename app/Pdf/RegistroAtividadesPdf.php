<?php

namespace App\Pdf;

use App\Models\RegistroDeAtividades;

class RegistroAtividadesPdf extends BaseReportePdf
{
    protected ?string $fechaInicio;
    protected ?string $fechaFin;

    public function __construct(?string $fechaInicio = null, ?string $fechaFin = null)
    {
        parent::__construct('Reporte de Registro de Actividades');

        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    protected function view(): string
    {
        return 'pdf.registro_actividades';
    }

    protected function data(): array
    {
        $query = RegistroDeAtividades::with(['encargado', 'estado']);

        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('fecha', [$this->fechaInicio, $this->fechaFin]);
        }

        $registros = $query->get()->map(function ($registro) {
            // Encode string fields
            $registro->descripcion = $this->utf8($registro->descripcion);
            $registro->tipo_actividad = $this->utf8($registro->tipo_actividad);
            $registro->parcela = $this->utf8($registro->parcela);
            $registro->hora = $this->utf8($registro->hora);
            
            // Encode related model fields
            if ($registro->encargado) {
                $registro->encargado->name = $this->utf8($registro->encargado->name);
            }
            
            if ($registro->estado) {
                $registro->estado->nombre = $this->utf8($registro->estado->nombre);
            }

            return $registro;
        });

        return [
            'registros' => $registros,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ];
    }

}
