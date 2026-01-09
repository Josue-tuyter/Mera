<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EstadoChartAvanceDistribution extends ChartWidget
{
    protected ?string $heading = 'Distribución % de avance';

    protected function getData(): array
    {
        $rows = DB::table('estados')->select('nombre','porcentaje_avance')->get();

        return [
            'datasets' => [[ 'data' => $rows->pluck('porcentaje_avance')->all(), 'backgroundColor' => array_map(fn($i)=>'rgba(72,187,120,0.6)',$rows->pluck('porcentaje_avance')->all()) ]],
            'labels' => $rows->pluck('nombre')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
