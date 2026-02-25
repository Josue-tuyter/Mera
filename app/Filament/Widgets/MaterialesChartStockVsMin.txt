<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MaterialesChartStockVsMin extends ChartWidget
{
    protected ?string $heading = 'Stock vs Stock mínimo (selección)';
    
    protected ?string $maxHeight = '400px';

    protected function getData(): array
    {
        $rows = DB::table('materiales_e_insumos')
            ->select('nombre', 'stock', 'stock_minimo')
            ->orderByDesc('stock')
            ->limit(6)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Stock Actual', 
                    'data' => $rows->pluck('stock')->all(), 
                    'backgroundColor' => '#BF712C', // Bronce Cacao
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'Stock Mínimo', 
                    'data' => $rows->pluck('stock_minimo')->all(), 
                    'backgroundColor' => '#BF304A', // Rojo Cacao (Alerta)
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $rows->pluck('nombre')->all(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => ['display' => false],
                ],
                'x' => [
                    'grid' => ['display' => false],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}