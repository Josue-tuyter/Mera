<?php

namespace App\Filament\Resources\MaterialesEInsumos\Pages;

use App\Filament\Resources\MaterialesEInsumos\MaterialesEInsumosResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateMaterialesEInsumos extends CreateRecord
{
    protected static string $resource = MaterialesEInsumosResource::class;

        protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
