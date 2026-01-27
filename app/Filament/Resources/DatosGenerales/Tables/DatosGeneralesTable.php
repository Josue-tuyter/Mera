<?php

namespace App\Filament\Resources\DatosGenerales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn as Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;

class DatosGeneralesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre_finca')->label('Finca')->sortable()->searchable(),
                TextColumn::make('propietario')->label('Propietario')->toggleable()->searchable(),
                TextColumn::make('area_hectareas')->label('Área (ha)')->numeric()->toggleable(),
                TextColumn::make('ubicacion')->label('Ubicación')->toggleable()->wrap(),
                TextColumn::make('variedad_cacao')->label('Variedad')->toggleable()->searchable(),
                TextColumn::make('altitud_m')->label('Altitud (m)')->toggleable(),
                TextColumn::make('lluvia_media_mm')->label('Lluvia media (mm)')->toggleable(),
                TextColumn::make('certificado_organico')->label('Orgánico')->toggleable(),
                TextColumn::make('contacto_email')->label('Email')->toggleable(),
                TextColumn::make('telefono')->label('Teléfono')->toggleable(),
                TextColumn::make('notas')->label('Notas')->limit(50)->wrap()->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Eliminar Datos Generales')
                        ->modalDescription('¿Está seguro de que desea eliminar los datos generales? Esta es una acción crítica.'),
                ]),
            ])
            ->paginated([10]); // Mostrar máximo 10 registros por página
    }
}
