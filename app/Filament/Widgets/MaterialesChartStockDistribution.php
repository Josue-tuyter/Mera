<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MaterialesChartStockDistribution extends ChartWidget
{
    protected ?string $heading = 'Top materiales por stock';

    protected function getData(): array
    {
        $rows = DB::table('materiales_e_insumos')
            ->select('nombre', 'stock')
            ->orderByDesc('stock')
            ->limit(8)
            ->get();

        return [
            'datasets' => [[
                'label' => 'Stock',
                'data' => $rows->pluck('stock')->all(),
                'backgroundColor' => 'rgba(99,179,119,0.85)',
            ]],
            'labels' => $rows->pluck('nombre')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'horizontalBar';
    }
}
