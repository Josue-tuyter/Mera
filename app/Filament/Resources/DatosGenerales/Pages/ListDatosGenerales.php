<?php

namespace App\Filament\Resources\DatosGenerales\Pages;

use App\Filament\Resources\DatosGenerales\DatosGeneralesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDatosGenerales extends ListRecords
{
    protected static string $resource = DatosGeneralesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
