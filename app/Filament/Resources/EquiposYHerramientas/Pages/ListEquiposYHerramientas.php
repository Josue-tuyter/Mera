<?php

namespace App\Filament\Resources\EquiposYHerramientas\Pages;

use App\Filament\Resources\EquiposYHerramientas\EquiposYHerramientaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEquiposYHerramientas extends ListRecords
{
    protected static string $resource = EquiposYHerramientaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
