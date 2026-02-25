<?php

namespace App\Filament\Widgets;

use App\Models\MaterialesEInsumos;
use App\Models\EquiposYHerramienta;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ResumenStock extends BaseWidget
{
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Insumos en Alerta', MaterialesEInsumos::whereColumn('stock', '<=', 'stock_minimo')->count())
                ->description('Bajo el stock mínimo')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->chart([5, 10, 8, 15, 20]) // Gráfico de urgencia
                ->color('danger'), // Rojo Cacao en tu CSS

            Stat::make('Equipos Disponibles', EquiposYHerramienta::where('disponible', true)->count())
                ->description('Operatividad actual')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'), // Amarillo/Oro Cacao

            // Stat::make('Mantenimientos Próximos', EquiposYHerramienta::whereDate('proximo_mantenimiento', '<=', now()->addDays(7))->count())
            //     ->description('Próximos 7 días')
            //     ->descriptionIcon('heroicon-m-wrench-screwdriver')
            //     ->color('warning'), // Bronce Cacao
        ];
    }
}