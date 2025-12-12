<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\EquiposYHerramienta;
use Illuminate\Support\Facades\Schema;

class EquipmentMaintenanceWidget extends Widget
{
    protected string $view = 'filament.widgets.equipment-maintenance';

    protected function getViewData(): array
    {
        if (! Schema::hasTable('equipos_y_herramientas')) {
            return [ 'items' => collect() ];
        }

        // Next 10 equipments with nearest maintenance date
        $items = EquiposYHerramienta::query()
            ->whereNotNull('proximo_mantenimiento')
            ->orderBy('proximo_mantenimiento', 'asc')
            ->limit(10)
            ->get(['id','nombre','proximo_mantenimiento','disponible']);

        return [
            'items' => $items,
        ];
    }
}
