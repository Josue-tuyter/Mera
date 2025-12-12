<?php

namespace App\Filament\Resources\MaterialesEInsumos\Pages;

use App\Filament\Resources\MaterialesEInsumos\MaterialesEInsumosResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaterialesEInsumos extends ListRecords
{
    protected static string $resource = MaterialesEInsumosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
