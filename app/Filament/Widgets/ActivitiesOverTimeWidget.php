<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\RegistroDeAtividades;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ActivitiesOverTimeWidget extends Widget
{
    protected string $view = 'filament.widgets.activities-over-time';

    public $labels = [];
    public $datasets = [];

    protected function getViewData(): array
    {
        if (! Schema::hasTable('registro_de_atividades')) {
            return [
                'labels' => [],
                'datasets' => [],
            ];
        }
        // Last 12 months
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }

        $types = RegistroDeAtividades::query()->select('tipo_actividad')->distinct()->pluck('tipo_actividad')->toArray();

        $labels = $months->map(fn($m) => Carbon::createFromFormat('Y-m', $m)->format('M Y'));

        $datasets = [];
        foreach ($types as $type) {
            $data = [];
            foreach ($months as $month) {
                [$y, $m] = explode('-', $month);
                $count = RegistroDeAtividades::where('tipo_actividad', $type)
                    ->whereYear('fecha', $y)
                    ->whereMonth('fecha', $m)
                    ->count();
                $data[] = $count;
            }
            $datasets[] = [
                'label' => ucfirst($type),
                'data' => $data,
            ];
        }

        return [
            'labels' => $labels->toArray(),
            'datasets' => $datasets,
        ];
    }
}
