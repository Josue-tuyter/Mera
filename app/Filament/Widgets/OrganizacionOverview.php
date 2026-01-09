<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class OrganizacionOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $table = 'organizacions';

        $total = (int) DB::table($table)->count();
        $active = (int) DB::table($table)->where('activo', true)->count();
        $totalRegistros = (int) DB::table('registro_de_atividades')->count();
        $avgPerOrg = $total ? round($totalRegistros / $total, 1) : 0;

        return [
            Stat::make('Organizaciones', $total)->description('Total de organizaciones')->color('primary'),
            Stat::make('Activas', $active)->description('Organizaciones activas')->color('success'),
            Stat::make('Registros (total)', $totalRegistros)->description('Registros vinculados')->color('secondary'),
            Stat::make('Promedio registros/org', $avgPerOrg)->description('Registros promedio por organización')->color('warning'),
        ];
    }
}
