<?php

namespace App\Exports;

use App\Models\RegistroDeAtividades;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RegistroActividadesExport extends BaseReporteExport implements FromCollection, WithHeadings
{
    protected ?string $fechaInicio;
    protected ?string $fechaFin;

    public function __construct(
        string $titulo,
        ?string $fechaInicio = null,
        ?string $fechaFin = null
    ) {
        parent::__construct($titulo);

        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    /**
     * Datos
     */
    public function collection(): Collection
    {
        $query = RegistroDeAtividades::with(['encargado', 'estado']);

        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('fecha', [$this->fechaInicio, $this->fechaFin]);
        }

        return $query->get()->map(function ($registro) {
            return [
                $registro->fecha?->format('d/m/Y'),
                $registro->hora,
                $registro->tipo_actividad,
                $registro->descripcion,
                $registro->duracion_minutos . ' min',
                $registro->encargado?->name,
                $registro->estado?->nombre,
                $registro->parcela,
            ];
        });
    }

    /**
     * Cabecera de columnas
     */
    public function headings(): array
    {
        return [
            'Fecha',
            'Hora',
            'Tipo de actividad',
            'Descripción',
            'Duración',
            'Encargado',
            'Estado',
            'Parcela',
        ];
    }

    /**
     * Estilo de la cabecera de la tabla
     */
    protected function styleTableHeader($sheet): void
    {
        $sheet->getStyle('A6:H6')
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF305496');

        $sheet->getStyle('A6:H6')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
    }
}