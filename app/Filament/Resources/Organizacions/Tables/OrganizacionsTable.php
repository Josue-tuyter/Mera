<?php

namespace App\Filament\Resources\Organizacions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

class OrganizacionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')->label('Nombre')->searchable()->sortable(),
                TextColumn::make('descripcion')->label('Descripción')->limit(60)->toggleable(),
                TextColumn::make('responsable.name')->label('Responsable')->searchable()->toggleable(),
                TextColumn::make('fecha_inicio')->label('Inicio')->sortable()->toggleable(),
                TextColumn::make('fecha_fin')->label('Fin')->sortable()->toggleable(),
                TextColumn::make('objetivo')->label('Objetivo')->limit(80)->toggleable(),
                BooleanColumn::make('activo')->label('Activo')->sortable(),
            ])
            ->filters([
                SelectFilter::make('responsable_id')->label('Responsable')->relationship('responsable','name'),

                Filter::make('fecha_periodo')
                    ->form([
                        DatePicker::make('fecha_from')->label('Desde'),
                        DatePicker::make('fecha_to')->label('Hasta'),
                    ])
                    ->query(function ($query, $data) {
                        if ($data['fecha_from'] ?? false) {
                            $query->where('fecha_inicio', '>=', $data['fecha_from']);
                        }
                        if ($data['fecha_to'] ?? false) {
                            $query->where('fecha_fin', '<=', $data['fecha_to']);
                        }
                    }),

                SelectFilter::make('activo')->label('Activo')->options([1 => 'Activo', 0 => 'Inactivo']),
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
