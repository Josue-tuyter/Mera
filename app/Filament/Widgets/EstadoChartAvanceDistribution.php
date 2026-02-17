<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\RegistroDeAtividades;
use Illuminate\Support\Facades\DB;

class EstadoChartAvanceDistribution extends ChartWidget
{
    protected ?string $heading = 'Distribución de Actividades por Estado';
    
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Consultamos la base de datos vinculando las actividades con sus estados
        // Agrupamos por el nombre del estado para contar cuántas actividades tiene cada uno
        $data = RegistroDeAtividades::join('estados', 'registro_de_atividades.estado_id', '=', 'estados.id')
            ->select('estados.nombre', DB::raw('count(*) as total'))
            ->groupBy('estados.nombre')
            ->get();

        // Tu paleta de colores Cocoa personalizada
        $palette = [
            '#BF304A', // Rojo Cacao
            '#F2C063', // Amarillo Cacao
            '#BF712C', // Bronce
            '#8C4830', // Marrón Cacao
            '#D94141', // Coral Cacao
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Actividades',
                    'data' => $data->pluck('total')->all(), // Los conteos reales
                    'backgroundColor' => array_values(array_slice(array_merge($palette, $palette), 0, $data->count())),
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ]
            ],
            'labels' => $data->pluck('nombre')->all(), // Los nombres de los estados (Completado, Pendiente, etc.)
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}