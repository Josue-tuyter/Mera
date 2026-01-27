<?php

namespace App\Filament\Resources\DatosGenerales\Pages;

use App\Filament\Resources\DatosGenerales\DatosGeneralesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDatosGenerales extends CreateRecord
{
    protected static string $resource = DatosGeneralesResource::class;

        protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
