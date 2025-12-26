<?php

namespace App\Exports;


use App\Models\EquiposYHerramienta;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class EquiposYHerramientasExport extends BaseReporteExport implements FromCollection, WithHeadings
{
    public function __construct()
    {
        parent::__construct('Reporte de Equipos y Herramientas');
    }

    public function collection(): Collection
    {
        return EquiposYHerramienta::all()->map(fn ($equipo) => [
            $equipo->nombre,
            $equipo->tipo,
            $equipo->estado,
            $equipo->descripcion,
        ]);
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Tipo',
            'Estado',
            'Descripción',
        ];
    }

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