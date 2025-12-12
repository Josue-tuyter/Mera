<?php

namespace App\Filament\Resources\EquiposYHerramientas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class EquiposYHerramientasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')->searchable()->sortable(),
                TextColumn::make('serial')
                    ->label('Serial')->toggleable(),
                BooleanColumn::make('disponible')
                    ->label('Disponible')->sortable(),
                TextColumn::make('proximo_mantenimiento')
                    ->label('Próximo mantenimiento')->toggleable(),
                TextColumn::make('ubicacion')
                    ->label('Ubicación')->toggleable(),
                TextColumn::make('responsable.name')
                    ->label('Responsable')->toggleable()->searchable(),
                TextColumn::make('costo_mantenimiento_estimado')
                    ->label('Costo mantenimiento')->numeric()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('responsable_id')->label('Responsable')->relationship('responsable','name'),
                Filter::make('needing_maintenance')
                    ->label('Necesita mantenimiento')
                    ->query(fn($query) => $query->whereColumn('proximo_mantenimiento', '<=', now())),
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
