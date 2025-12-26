<?php

namespace App\Exports;


use App\Models\MaterialesEInsumos;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MaterialesEInsumosExport extends BaseReporteExport implements FromCollection, WithHeadings
{
    public function __construct()
    {
        parent::__construct('Reporte de Materiales e Insumos');
    }

    public function collection(): Collection
    {
        return MaterialesEInsumos::all()->map(fn ($item) => [
            $item->nombre,
            $item->categoria,
            $item->stock,
            $item->unidad,
        ]);
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Categoría',
            'Stock',
            'Unidad',
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