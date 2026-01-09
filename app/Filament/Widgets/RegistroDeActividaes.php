<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\RegistroDeAtividades;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class RegistroDeActividaes extends ChartWidget
{
    protected ?string $heading = 'Registro de actividades (últimos 14 días)';

    protected function getData(): array
    {
        $days = 14;
        $now = Carbon::today();

        $labels = [];
        $counts = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $labels[] = $date->locale('es')->isoFormat('D MMM');

            $counts[] = RegistroDeAtividades::whereDate('fecha', $date)->count();
        }

        // Totales y estadísticas rápidas
        $total = RegistroDeAtividades::count();
        $avgDuration = RegistroDeAtividades::whereNotNull('duracion_minutos')->avg('duracion_minutos');
        $avgDuration = $avgDuration ? round($avgDuration, 1) . ' min' : 'N/A';

        $topTypes = RegistroDeAtividades::select('tipo_actividad', DB::raw('count(*) as cnt'))
            ->whereNotNull('tipo_actividad')
            ->groupBy('tipo_actividad')
            ->orderByDesc('cnt')
            ->limit(3)
            ->get()
            ->pluck('tipo_actividad')
            ->filter()
            ->values()
            ->all();

        $topTypesText = $topTypes ? implode(', ', $topTypes) : '—';

        return [
            'datasets' => [
                [
                    'label' => 'Actividades por día',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(72,187,120,0.18)',
                    'borderColor' => 'rgba(47,133,90,1)',
                    'pointBackgroundColor' => 'rgba(47,133,90,1)',
                    'borderWidth' => 2,
                    'tension' => 0.3,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
            'meta' => [
                'total' => $total,
                'avg_duration' => $avgDuration,
                'top_types' => $topTypesText,
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        $data = $this->getData();
        $meta = $data['meta'] ?? [];

        $title = "Total: {$meta['total']} — Promedio duración: {$meta['avg_duration']} — Tipos: {$meta['top_types']}";

        return [
            'responsive' => true,
            'plugins' => [
                'legend' => ['display' => false],
                'title' => [
                    'display' => true,
                    'text' => $title,
                    'font' => ['size' => 13],
                ],
                'tooltip' => ['mode' => 'index', 'intersect' => false],
            ],
            'scales' => [
                'y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]],
            ],
        ];
    }
}
