<?php

namespace App\Pdf;

use App\Models\MaterialesEInsumos as MaterialEInsumo;

class MaterialesEInsumosPdf extends BaseReportePdf
{
    public function __construct()
    {
        parent::__construct('Reporte de Materiales e Insumos');
    }

    protected function view(): string
    {
        return 'pdf.insumos';
    }

    protected function data(): array
    {
        $insumos = MaterialEInsumo::all()->map(function ($insumo) {
            $insumo->nombre = $this->utf8($insumo->nombre);
            $insumo->descripcion = $this->utf8($insumo->descripcion);
            $insumo->unidad = $this->utf8($insumo->unidad);
            $insumo->proveedor = $this->utf8($insumo->proveedor);
            $insumo->lote = $this->utf8($insumo->lote);

            return $insumo;
        });

        return [
            'insumos' => $insumos,
        ];
    }
}
