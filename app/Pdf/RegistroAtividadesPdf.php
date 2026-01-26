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

        return [
            'registros' => $query->get(),
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ];
    }
}
