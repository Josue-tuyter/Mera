<?php

namespace App\Filament\Resources\MaterialesEInsumos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class MaterialesEInsumosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')->label('Nombre')->searchable()->sortable(),
                TextColumn::make('descripcion')->label('Descripción')->limit(50)->toggleable(),
                TextColumn::make('stock')->label('Stock')->numeric()->sortable(),
                TextColumn::make('unidad')->label('Unidad')->toggleable(),
                TextColumn::make('stock_minimo')->label('Stock mínimo')->numeric()->toggleable(),
                TextColumn::make('proveedor')->label('Proveedor')->toggleable(),
                TextColumn::make('lote')->label('Lote')->toggleable(),
                TextColumn::make('fecha_vencimiento')->label('Vencimiento')->toggleable(),
                TextColumn::make('responsable.name')->label('Responsable')->toggleable()->searchable(),
                BooleanColumn::make('activo')
                    ->label('Activo')->sortable(),
            ])
            ->filters([
                SelectFilter::make('responsable_id')->label('Responsable')->relationship('responsable','name'),
                Filter::make('low_stock')
                    ->label('Bajo stock')
                    ->query(fn($query) => $query->whereColumn('stock', '<=', 'stock_minimo')),
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
