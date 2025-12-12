<?php

namespace App\Filament\Resources\EquiposYHerramientas\Pages;

use App\Filament\Resources\EquiposYHerramientas\EquiposYHerramientaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEquiposYHerramienta extends EditRecord
{
    protected static string $resource = EquiposYHerramientaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
