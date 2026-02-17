<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class EstadoOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $table = 'estados';

        $total = (int) DB::table($table)->count();
        $avgAvance = DB::table($table)->avg('porcentaje_avance');
        
        $topEstado = DB::table('registro_de_atividades as r')
            ->join('estados as e', 'r.estado_id', '=', 'e.id')
            ->select('e.nombre', DB::raw('count(r.id) as cnt'))
            ->groupBy('e.id','e.nombre')
            ->orderByDesc('cnt')
            ->limit(1)
            ->pluck('nombre')
            ->first();

        return [
            Stat::make('Estados', $total)
                ->description('Configuración de flujo')
                ->descriptionIcon('heroicon-m-list-bullet')
                ->color('info'), // Mapeado a Bronce en tu CSS

            Stat::make('Avance promedio', round($avgAvance ?? 0, 1) . '%')
                ->description('Progreso general')
                ->descriptionIcon('heroicon-m-chart-pie')
                ->chart([10, 25, 45, 60, round($avgAvance ?? 0)])
                ->color('warning'), // Mapeado a Amarillo Cacao

            Stat::make('Estado dominante', $topEstado ?? '—')
                ->description('Mayor carga de trabajo')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'), // Mapeado a Coral/Rojo
        ];
    }
}