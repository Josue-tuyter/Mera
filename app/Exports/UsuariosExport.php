<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UsuariosExport extends BaseReporteExport implements FromCollection, WithHeadings
{
    public function __construct()
    {
        parent::__construct('Reporte de Usuarios');
    }

    public function collection(): Collection
    {
        return User::all()->map(function ($user) {
            return [
                $user->name,
                $user->email,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Correo',
        ];
    }

    protected function styleTableHeader($sheet): void
    {
        $sheet->getStyle('A6:B6')
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF9BBB59');

        $sheet->getStyle('A6:B6')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
    }
}
