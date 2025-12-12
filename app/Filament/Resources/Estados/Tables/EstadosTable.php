<?php

namespace App\Filament\Resources\Estados\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn as Column;
use Filament\Tables\Filters\SelectFilter;

class EstadosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')->label('Nombre')->searchable()->sortable(),
                TextColumn::make('descripcion')->label('Descripción')->limit(50)->toggleable(),
                BadgeColumn::make('porcentaje_avance')
                    ->label('% Avance')
                    ->colors([
                        'danger' => fn($state): bool => $state < 30,
                        'warning' => fn($state): bool => $state >= 30 && $state < 70,
                        'success' => fn($state): bool => $state >= 70,
                    ])
                    ->sortable(),
                TextColumn::make('organizacion.nombre')->label('Organización')->toggleable()->searchable(),
            ])
            ->filters([
                SelectFilter::make('organizacion_id')->label('Organización')->relationship('organizacion','nombre'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
