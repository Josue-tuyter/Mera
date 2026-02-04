<?php

namespace App\Filament\Resources\RegistroDeAtividades\Pages;

use App\Filament\Resources\RegistroDeAtividades\RegistroDeAtividadesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRegistroDeAtividades extends EditRecord
{
    protected static string $resource = RegistroDeAtividadesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

            protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
