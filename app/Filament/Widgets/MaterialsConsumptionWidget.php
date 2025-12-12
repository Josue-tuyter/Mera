<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\RegistroDeAtividades;
use App\Models\MaterialesEInsumos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MaterialsConsumptionWidget extends Widget
{
    protected string $view = 'filament.widgets.materials-consumption';

    protected function getViewData(): array
    {
        // Avoid errors when tables aren't present yet
        if (! Schema::hasTable('materiales_e_insumos') || ! Schema::hasTable('registro_actividad_material')) {
            return [
                'labels' => [],
                'data' => [],
            ];
        }

        // Sum cantidades by material for last 12 months
        $materials = MaterialesEInsumos::pluck('nombre', 'id');

        $labels = [];
        $data = [];

        foreach ($materials as $id => $name) {
            $labels[] = $name;
            // Sum cantidad_usada from pivot table
            $total = DB::table('registro_actividad_material')
                ->where('material_id', $id)
                ->sum('cantidad_usada');
            $data[] = (float) $total;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
