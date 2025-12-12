<?php

namespace App\Filament\Resources\MaterialesEInsumos\Pages;

use App\Filament\Resources\MaterialesEInsumos\MaterialesEInsumosResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaterialesEInsumos extends EditRecord
{
    protected static string $resource = MaterialesEInsumosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
