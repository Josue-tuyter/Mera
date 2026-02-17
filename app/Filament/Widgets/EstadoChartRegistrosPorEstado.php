<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EstadoChartRegistrosPorEstado extends ChartWidget
{
    protected ?string $heading = 'Registros por estado';

    // Aumentamos un poco el maxHeight para que tenga más presencia
    protected ?string $maxHeight = '400px'; 

    protected function getData(): array
    {
        $rows = DB::table('estados as e')
            ->leftJoin('registro_de_atividades as r', 'r.estado_id', '=', 'e.id')
            ->select('e.nombre', DB::raw('count(r.id) as cnt'))
            ->groupBy('e.id','e.nombre')
            ->orderByDesc('cnt')
            ->get();

        $palette = [
            '#BF712C', // Bronce
            '#F2C063', // Amarillo Cacao
            '#BF304A', // Rojo Cacao
            '#8C4830', // Marrón Cacao
            '#D94141', // Coral Cacao
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de Registros',
                    'data' => $rows->pluck('cnt')->all(),
                    'backgroundColor' => array_values(array_slice(array_merge($palette, $palette), 0, $rows->count())),
                    'borderRadius' => 8,
                ]
            ],
            'labels' => $rows->pluck('nombre')->all(),
        ];
    }

    // ESTO ES LO QUE ELIMINA EL ESPACIO VACÍO
    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false, // Obligatorio para estirar
            'aspectRatio' => 2, // Ajusta este número (1.5 o 2) para controlar el estiramiento
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'boxWidth' => 10, // Hace la leyenda más pequeña para ganar espacio
                        'padding' => 20,
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [ 'display' => false ], // Limpia el fondo para que se vea más amplio
                ],
                'x' => [
                    'grid' => [ 'display' => false ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}