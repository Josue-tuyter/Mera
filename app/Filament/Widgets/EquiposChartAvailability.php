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
        $percentAvailable = $total ? round(($available / $total) * 100) . '%' : '0%';

        return [
            Stat::make('Total equipos', $total)
                ->description('Patrimonio registrado')
                ->descriptionIcon('heroicon-m-cube')
                ->chart([7, 10, 5, 15, 10, 17, $total]) // Genera la mini gráfica
                ->color('info'),

            Stat::make('Disponibles', $available)
                ->description("{$percentAvailable} de operatividad")
                ->descriptionIcon('heroicon-m-check-badge')
                ->chart([$available, 12, 15, 10, 20, 18, $available])
                ->color('success'),

            Stat::make('No disponibles', $unavailable)
                ->description('En uso o mantenimiento')
                ->descriptionIcon('heroicon-m-x-circle')
                ->chart([2, 5, 3, 8, 4, 10, $unavailable])
                ->color('danger'),
        ];
    }
}