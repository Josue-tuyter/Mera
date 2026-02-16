<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class MaterialesOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $table = 'materiales_e_insumos';

        $total = (int) DB::table($table)->count();
        $lowStock = (int) DB::table($table)->whereColumn('stock', '<=', 'stock_minimo')->count();
        $expired = (int) DB::table($table)->whereNotNull('fecha_vencimiento')->whereDate('fecha_vencimiento', '<', now())->count();
        $avgStock = DB::table($table)->avg('stock');

        return [
            Stat::make('Total materiales', $total)
                ->description('Materiales e insumos registrados')
                ->color('primary'),

            Stat::make('Bajo stock', $lowStock)
                ->description('Materiales con stock por debajo del mínimo')
                ->color('warning'),

            Stat::make('Vencidos', $expired)
                ->description('Materiales con fecha de vencimiento pasada')
                ->color('danger'),

            Stat::make('Stock promedio', round($avgStock ?? 0, 1))
                ->description('Promedio de unidades en inventario')
                ->color('secondary'),
        ];
    }
}
