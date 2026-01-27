<?php

namespace App\Filament\Resources\Estados\Pages;

use App\Filament\Resources\Estados\EstadoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEstado extends CreateRecord
{
    protected static string $resource = EstadoResource::class;
        protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
