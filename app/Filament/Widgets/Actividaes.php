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

        $topTypes = DB::table($table)
            ->select('tipo_actividad', DB::raw('count(*) as cnt'))
            ->whereNotNull('tipo_actividad')
            ->groupBy('tipo_actividad')
            ->orderByDesc('cnt')
            ->limit(2)
            ->get()
            ->pluck('tipo_actividad')
            ->filter()
            ->values()
            ->all();

        $topTypesDesc = $topTypes ? implode(', ', $topTypes) : '—';

        $recent = DB::table($table)
            ->select('fecha', 'hora', 'tipo_actividad', 'parcela')
            ->orderByDesc('fecha')
            ->orderByDesc('hora')
            ->limit(1)
            ->first();

        $recentDesc = 'Sin registros';
        if ($recent) {
            $when = $recent->fecha . ($recent->hora ? ' ' . substr($recent->hora, 0, 5) : '');
            $recentDesc = sprintf('%s — %s (%s)', $when, $recent->tipo_actividad ?? '—', $recent->parcela ?? 'sin parcela');
        }

        return [
            Stat::make('Total actividades', $total)
                ->description('Registros totales en la tabla')
                ->descriptionIcon('heroicon-o-queue-list')
                ->color('primary'),

            Stat::make('Hoy', $today)
                ->description('Actividades registradas hoy')
                ->descriptionIcon('heroicon-o-sun')
                ->color('warning'),

            Stat::make('Duración promedio', $avgDurationFormatted)
                ->description('Promedio en minutos (solo registros con duración)')
                ->descriptionIcon('heroicon-o-clock')
                ->color('secondary'),

            Stat::make('Tipos más comunes', $topTypesDesc)
                ->description('Top 2 tipos de actividad')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success'),

            Stat::make('Último registro', $recent ? 'Ver detalle' : '—')
                ->description($recentDesc)
                ->descriptionIcon('heroicon-o-document-text')
                ->color('gray'),
        ];
    }
}
