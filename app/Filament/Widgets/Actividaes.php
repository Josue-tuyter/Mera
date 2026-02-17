<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Actividaes extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $table = 'registro_de_atividades';

        $total = (int) DB::table($table)->count();

        $today = (int) DB::table($table)
            ->whereDate('fecha', Carbon::today())
            ->count();

        $avgDuration = DB::table($table)
            ->whereNotNull('duracion_minutos')
            ->avg('duracion_minutos');

        $avgDurationFormatted = $avgDuration ? round($avgDuration, 1) . ' min' : 'N/A';

        // Tipos más comunes
        $topTypes = DB::table($table)
            ->select('tipo_actividad', DB::raw('count(*) as cnt'))
            ->whereNotNull('tipo_actividad')
            ->groupBy('tipo_actividad')
            ->orderByDesc('cnt')
            ->limit(2)
            ->get()
            ->pluck('tipo_actividad')
            ->all();

        $topTypesDesc = $topTypes ? implode(', ', $topTypes) : '—';

        // Último registro
        $recent = DB::table($table)
            ->select('fecha', 'hora', 'tipo_actividad', 'parcela')
            ->orderByDesc('fecha')
            ->orderByDesc('hora')
            ->limit(1)
            ->first();

        $recentDesc = 'Sin registros';
        if ($recent) {
            $when = Carbon::parse($recent->fecha)->format('d/m') . ($recent->hora ? ' ' . substr($recent->hora, 0, 5) : '');
            $recentDesc = sprintf('%s — %s (%s)', $when, $recent->tipo_actividad ?? '—', $recent->parcela ?? 'sin parcela');
        }

        return [
            Stat::make('Total actividades', $total)
                ->description('Patrimonio de registros')
                ->descriptionIcon('heroicon-m-rectangle-group')
                ->chart([7, 4, 10, 3, 15, 4, $total]) // Gráfico de actividad
                ->color('info'),

            Stat::make('Hoy', $today)
                ->description('Nuevas tareas')
                ->descriptionIcon('heroicon-m-bolt')
                ->chart([0, 2, 5, 3, $today])
                ->color('warning'),

            Stat::make('Duración promedio', $avgDurationFormatted)
                ->description('Eficiencia por tarea')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),

            Stat::make('Más comunes', $topTypesDesc)
                ->description('Tipos predominantes')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make('Último registro', $recent ? 'Activo' : '—')
                ->description($recentDesc)
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('gray'),
        ];
    }
}