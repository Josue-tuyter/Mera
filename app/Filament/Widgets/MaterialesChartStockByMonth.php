<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaterialesChartStockByMonth extends ChartWidget
{
    protected ?string $heading = 'Nuevos materiales por mes (últimos 7 meses)';

    protected function getData(): array
    {
        $now = Carbon::now();
        $months = [];
        $counts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $start = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();

            $months[] = $date->locale('es')->isoFormat('MMM');
            $counts[] = DB::table('materiales_e_insumos')->whereBetween('created_at', [$start, $end])->count();
        }

        return [
            'datasets' => [[ 'label' => 'Nuevos registros', 'data' => $counts, 'backgroundColor' => 'rgba(72,187,120,0.6)', 'borderColor' => 'rgba(47,133,90,1)', ]],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
