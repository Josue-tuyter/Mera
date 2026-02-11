<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\MaterialesEInsumos;
use App\Models\EquiposYHerramienta;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ResumenStock extends BaseWidget
{
    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        return [
            Stat::make('Insumos en Alerta', MaterialesEInsumos::whereColumn('stock', '<=', 'stock_minimo')->count())
                ->description('Bajo el stock mínimo')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Equipos Disponibles', EquiposYHerramienta::where('disponible', true)->count())
                ->description('Listos para usar')
                ->color('success'),
            Stat::make('Mantenimientos Próximos', EquiposYHerramienta::whereDate('proximo_mantenimiento', '<=', now()->addDays(7))->count())
                ->description('En los próximos 7 días')
                ->color('warning'),
        ];
    }

}