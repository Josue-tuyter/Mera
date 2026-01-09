<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EstadoChartRegistrosPorEstado extends ChartWidget
{
    protected ?string $heading = 'Registros por estado';

    protected function getData(): array
    {
        $rows = DB::table('estados as e')
            ->leftJoin('registro_de_atividades as r', 'r.estado_id', '=', 'e.id')
            ->select('e.nombre', DB::raw('count(r.id) as cnt'))
            ->groupBy('e.id','e.nombre')
            ->orderByDesc('cnt')
            ->get();

        return [
            'datasets' => [[ 'label' => 'Registros', 'data' => $rows->pluck('cnt')->all(), 'backgroundColor' => 'rgba(99,179,119,0.8)' ]],
            'labels' => $rows->pluck('nombre')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
