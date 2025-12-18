<?php

namespace App\Filament\Resources\DatosGenerales\Pages;

use App\Filament\Resources\DatosGenerales\DatosGeneralesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDatosGenerales extends EditRecord
{
    protected static string $resource = DatosGeneralesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
