<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\RegistroDeAtividades;
use Illuminate\Support\Facades\Schema;

class ActivityStatusWidget extends Widget
{
    protected string $view = 'filament.widgets.activity-status';

    protected function getViewData(): array
    {
        if (! Schema::hasTable('registro_de_atividades') || ! Schema::hasTable('estados')) {
            return [
                'labels' => [],
                'data' => [],
            ];
        }
        $totals = RegistroDeAtividades::selectRaw('estado_id, count(*) as total')
            ->groupBy('estado_id')
            ->pluck('total', 'estado_id')
            ->toArray();

        $labels = [];
        $data = [];
        foreach ($totals as $estado_id => $total) {
            $estado = \App\Models\Estado::find($estado_id);
            $labels[] = $estado?->nombre ?? 'Sin estado';
            $data[] = (int) $total;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
