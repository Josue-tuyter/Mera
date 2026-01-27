<?php

namespace App\Filament\Resources\RegistroDeAtividades\Pages;

use App\Filament\Resources\RegistroDeAtividades\RegistroDeAtividadesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRegistroDeAtividades extends CreateRecord
{
    protected static string $resource = RegistroDeAtividadesResource::class;
    
        protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
