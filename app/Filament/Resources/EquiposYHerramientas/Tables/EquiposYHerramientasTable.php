<?php

namespace App\Filament\Resources\EquiposYHerramientas\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;


class EquiposYHerramientasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Imagen
                ImageColumn::make('imagen_url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/imgs/equipo.png'))
                    ->size(45),

                // Nombre
                TextColumn::make('nombre')
                    ->label('Equipo')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary')
                    ->description(fn ($record) => "S/N: " . ($record->serial ?? 'Sin registro')),

                // Estado
                IconColumn::make('disponible')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-s-check-circle')
                    ->falseIcon('heroicon-s-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),

                // Mantenimiento
                // TextColumn::make('proximo_mantenimiento')
                //     ->label('Mantenimiento')
                //     ->date('d M, Y')
                //     ->sortable()
                //     ->badge()
                //     ->color(fn ($state) => $state && Carbon::parse($state)->isPast() ? 'danger' : 'warning')
                //     ->icon('heroicon-m-calendar'),

                TextColumn::make('ubicacion')
                    ->label('Ubicación')
                    ->icon('heroicon-m-map-pin')
                    ->toggleable(),

                TextColumn::make('responsable.name')
                    ->label('Responsable')
                    ->toggleable(),

                TextColumn::make('costo_mantenimiento_estimado')
                    ->label('Costo')
                    ->money('USD')
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => intval($state)),
            ])
            ->filters([
                SelectFilter::make('responsable_id')
                    ->label('Responsable')
                    ->relationship('responsable', 'name')
                    ->searchable()
                    ->preload(),

            ])
            // AQUÍ ESTÁ LA SOLUCIÓN: USAMOS LA RUTA COMPLETA CON "\" AL INICIO
            ->actions([ 
                ActionsEditAction::make(),
                \Filament\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->icon('heroicon-m-trash')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
            //->striped();
    }
}