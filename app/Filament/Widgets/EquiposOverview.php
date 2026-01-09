<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EquiposOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $table = 'equipos_y_herramientas';

        $total = (int) DB::table($table)->count();
        $unavailable = (int) DB::table($table)->where('disponible', false)->count();
        $next30 = (int) DB::table($table)->whereBetween('proximo_mantenimiento', [Carbon::now(), Carbon::now()->addDays(30)])->count();
        $avgCost = DB::table($table)->avg('costo_mantenimiento_estimado');

        return [
            Stat::make('Total equipos', $total)->description('Equipos y herramientas')->color('primary'),
            Stat::make('No disponibles', $unavailable)->description('Equipos marcados como no disponibles')->color('danger'),
            Stat::make('Mant. próximos 30d', $next30)->description('Mantenimientos próximos')->color('warning'),
            Stat::make('Costo promedio', round($avgCost ?? 0, 2))->description('Costo estimado mantenimiento')->color('secondary'),
        ];
    }
}
