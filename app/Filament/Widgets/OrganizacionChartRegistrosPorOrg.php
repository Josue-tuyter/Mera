<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrganizacionChartRegistrosPorOrg extends ChartWidget
{
    protected ?string $heading = 'Registros por organización (top 8)';
    protected ?string $maxHeight = '350px';

    protected function getData(): array
    {
        $rows = DB::table('organizacions as o')
            ->leftJoin('registro_de_atividades as r', 'r.organizacion_id', '=', 'o.id')
            ->select('o.nombre', DB::raw('count(r.id) as cnt'))
            ->groupBy('o.id', 'o.nombre')
            ->orderByDesc('cnt')
            ->limit(8)
            ->get();

        return [
            'datasets' => [
                [ 
                    'label' => 'Registros', 
                    'data' => $rows->pluck('cnt')->all(), 
                    'backgroundColor' => '#BF712C', // Bronce Cacao
                    'borderRadius' => 6,
                ]
            ],
            'labels' => $rows->pluck('nombre')->all(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'indexAxis' => 'y', // Convertimos a barras horizontales para mejor lectura de nombres largos
            'scales' => [
                'x' => ['grid' => ['display' => false]],
                'y' => ['grid' => ['display' => false]],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}