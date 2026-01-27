<?php

namespace App\Filament\Resources\EquiposYHerramientas\Pages;

use App\Filament\Resources\EquiposYHerramientas\EquiposYHerramientaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEquiposYHerramienta extends CreateRecord
{
    protected static string $resource = EquiposYHerramientaResource::class;
        protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
