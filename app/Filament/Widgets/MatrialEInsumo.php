<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\MaterialesEInsumos;
use Carbon\Carbon;

class MatrialEInsumo extends ChartWidget
{
    protected ?string $heading = 'Materiales e Insumos';

    protected function getData(): array
    {
        $now = Carbon::now();

        $months = [];
        $counts = [];

        // Últimos 7 meses (incluye mes actual)
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $start = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();

            // Etiqueta en español abreviada
            $months[] = $date->locale('es')->isoFormat('MMM');

            $counts[] = MaterialesEInsumos::whereBetween('created_at', [$start, $end])->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Nuevos registros por mes',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                    'fill' => true,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        $total = MaterialesEInsumos::count();
        $lowStock = MaterialesEInsumos::whereColumn('stock', '<=', 'stock_minimo')->count();

        return [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'title' => [
                    'display' => true,
                    'text' => "Total: {$total} — Bajo stock: {$lowStock}",
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
