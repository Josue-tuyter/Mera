<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EquiposChartMaintenanceTimeline extends ChartWidget
{
    protected ?string $heading = 'Mantenimientos próximos (30 días)';

    protected function getData(): array
    {
        $start = Carbon::now();
        $labels = [];
        $counts = [];

        for ($i = 0; $i < 5; $i++) {
            $date = $start->copy()->addDays($i * 7);
            $labels[] = $date->locale('es')->isoFormat('D MMM');
            $counts[] = DB::table('equipos_y_herramientas')->whereBetween('proximo_mantenimiento', [$date->copy()->startOfDay(), $date->copy()->endOfDay()])->count();
        }

        return [
            'datasets' => [[ 'label' => 'Mant. por fecha', 'data' => $counts, 'backgroundColor' => 'rgba(99,179,119,0.6)' ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
