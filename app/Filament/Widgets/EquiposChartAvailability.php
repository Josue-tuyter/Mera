<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class EquiposChartAvailability extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = (int) DB::table('equipos_y_herramientas')->count();
        $available = (int) DB::table('equipos_y_herramientas')->where('disponible', true)->count();
        $unavailable = $total - $available;
        $percentAvailable = $total ? round($available / $total * 100) . '%' : '—';

        return [
            Stat::make('Total equipos', $total)
                ->description('Equipos y herramientas registrados')
                ->color('primary'),

            Stat::make('Disponibles', $available)
                ->description("{$percentAvailable} disponibles")
                ->color('success'),

            Stat::make('No disponibles', $unavailable)
                ->description('Equipos en uso o fuera de servicio')
                ->color('danger'),
        ];
    }
}
