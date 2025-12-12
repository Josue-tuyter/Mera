<?php

namespace App\Filament\Resources\RegistroDeAtividades\Pages;

use App\Filament\Resources\RegistroDeAtividades\RegistroDeAtividadesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRegistroDeAtividades extends ListRecords
{
    protected static string $resource = RegistroDeAtividadesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
