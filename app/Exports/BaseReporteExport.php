<?php

namespace App\Exports;

use App\Models\DatosGenerales;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

abstract class BaseReporteExport implements WithEvents, WithCustomStartCell
{
    protected string $titulo;

        public function startCell(): string
        {
            // 👇 AQUÍ está la clave
            return 'A6';
        }
    protected ?DatosGenerales $datosGenerales;

    public function __construct(string $titulo)
    {
        $this->titulo = $titulo;
        $this->datosGenerales = DatosGenerales::first();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------------------
                | LOGO
                |--------------------------------------------------------------------------
                */
                if (file_exists(public_path('images/logo.png'))) {
                    $logo = new Drawing();
                    $logo->setName('Logo');
                    $logo->setPath(public_path('images/logo.png'));
                    $logo->setHeight(80);
                    $logo->setCoordinates('A1');
                    $logo->setOffsetX(10);
                    $logo->setOffsetY(5);
                    $logo->setWorksheet($sheet);

                    $sheet->getRowDimension(1)->setRowHeight(70);
                    $sheet->getRowDimension(2)->setRowHeight(25);
                    $sheet->getRowDimension(3)->setRowHeight(25);
                }

                /*
                |--------------------------------------------------------------------------
                | ENCABEZADO INSTITUCIONAL
                |--------------------------------------------------------------------------
                */
                $sheet->mergeCells('B1:H1');
                $sheet->setCellValue('B1', $this->datosGenerales?->nombre_finca ?? 'FINCA');

                $sheet->mergeCells('B2:H2');
                $sheet->setCellValue(
                    'B2',
                    'Propietario: ' . ($this->datosGenerales?->propietario ?? '---')
                );

                $sheet->mergeCells('B3:H3');
                $sheet->setCellValue(
                    'B3',
                    'Fecha de exportación: ' . now()->timezone(config('app.timezone'))->format('d/m/Y')
                );

                /*
                |--------------------------------------------------------------------------
                | TÍTULO DEL REPORTE
                |--------------------------------------------------------------------------
                */
                $sheet->mergeCells('A5:H5');
                $sheet->setCellValue('A5', strtoupper($this->titulo));

                $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                /*
                |--------------------------------------------------------------------------
                | ESTILO DE CABECERA DE TABLA (HOOK)
                |--------------------------------------------------------------------------
                */
                $this->styleTableHeader($sheet);

                /*
                |--------------------------------------------------------------------------
                | AUTO SIZE
                |--------------------------------------------------------------------------
                */
                foreach ($sheet->getColumnIterator() as $column) {
                    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
                }
            },
        ];
    }

    /**
     * Cada export define su estilo de cabecera
     */
    protected function styleTableHeader($sheet): void
    {
        // vacío, lo define el hijo

    }
}