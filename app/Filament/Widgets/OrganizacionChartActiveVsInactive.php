<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class OrganizacionChartActiveVsInactive extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = (int) DB::table('organizacions')->count();
        $active = (int) DB::table('organizacions')->where('activo', true)->count();
        $inactive = $total - $active;
        $percentActive = $total ? round($active / $total * 100) . '%' : '—';

        return [
            Stat::make('Organizaciones', $total)
                ->description('Total de organizaciones')
                ->color('primary'),

            Stat::make('Activas', $active)
                ->description("{$percentActive} activas")
                ->color('success'),

            Stat::make('Inactivas', $inactive)
                ->description('Organizaciones inactivas')
                ->color('secondary'),
        ];
    }
}
