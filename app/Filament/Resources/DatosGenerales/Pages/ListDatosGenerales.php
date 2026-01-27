<?php

namespace App\Filament\Resources\DatosGenerales\Pages;

use App\Filament\Resources\DatosGenerales\DatosGeneralesResource;
use App\Models\DatosGenerales;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDatosGenerales extends ListRecords
{
    protected static string $resource = DatosGeneralesResource::class;

    protected function getHeaderActions(): array
    {
        $datosGeneralesCount = DatosGenerales::count();

        return [
            CreateAction::make()
                ->disabled($datosGeneralesCount >= 1)
                ->tooltip($datosGeneralesCount >= 1 ? 'Solo se permite un registro de datos generales' : ''),
        ];
    }
}
