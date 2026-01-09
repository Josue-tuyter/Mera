<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MaterialesChartStockVsMin extends ChartWidget
{
    protected ?string $heading = 'Stock vs Stock mínimo (selección)';

    protected function getData(): array
    {
        $rows = DB::table('materiales_e_insumos')
            ->select('nombre', 'stock', 'stock_minimo')
            ->orderByDesc('stock')
            ->limit(6)
            ->get();

        return [
            'datasets' => [
                ['label' => 'Stock', 'data' => $rows->pluck('stock')->all(), 'backgroundColor' => 'rgba(72,187,120,0.7)'],
                ['label' => 'Stock mínimo', 'data' => $rows->pluck('stock_minimo')->all(), 'backgroundColor' => 'rgba(255,99,71,0.5)'],
            ],
            'labels' => $rows->pluck('nombre')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
