<?php

namespace App\Filament\Resources\MaterialesEInsumos\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Actions\BulkActionGroup;

class MaterialesEInsumosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Imagen descriptiva (opcional, si tienes un campo o quieres un icono fijo)
                ImageColumn::make('foto_insumo')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/imgs/insumo.png')) // Asegúrate de tener esta imagen
                    ->size(45),

                // Nombre con descripción
                TextColumn::make('nombre')
                    ->label('Material / Insumo')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary')
                    ->description(fn ($record) => $record->descripcion ? str($record->descripcion)->limit(40) : 'Sin descripción'),

                // Stock con indicador de color (Badges)
                TextColumn::make('stock')
                    ->label('Stock Actual')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->weight('bold')
                    ->badge()
                    // Color dinámico: Rojo si es menor al mínimo, Naranja si está cerca, Verde si está bien
                    ->color(fn ($record) => 
                        $record->stock <= $record->stock_minimo ? 'danger' : 
                        ($record->stock <= $record->stock_minimo * 1.5 ? 'warning' : 'success')
                    )
                    ->formatStateUsing(fn ($state, $record) => "{$state} {$record->unidad}"),

                // Vencimiento con alerta
                TextColumn::make('fecha_vencimiento')
                    ->label('Vencimiento')
                    ->date('d M, Y')
                    ->sortable()
                    ->badge()
                    ->icon('heroicon-m-calendar')
                    ->color(fn ($state) => 
                        $state && Carbon::parse($state)->isPast() ? 'danger' : 
                        ($state && Carbon::parse($state)->diffInDays(now()) < 30 ? 'warning' : 'gray')
                    )
                    ->toggleable(),

                // Datos logísticos resumidos
                TextColumn::make('lote')
                    ->label('Lote/Prov.')
                    ->description(fn ($record) => "Prov: " . ($record->proveedor ?? 'N/A'))
                    ->toggleable(),

                // Responsable con Icono
                TextColumn::make('responsable.name')
                    ->label('Responsable')
                    ->icon('heroicon-m-user')
                    ->toggleable()
                    ->searchable(),

                // Estado activo/inactivo con iconos
                IconColumn::make('activo')
                    ->label('Estatus')
                    ->boolean()
                    ->trueIcon('heroicon-s-check-circle')
                    ->falseIcon('heroicon-s-minus-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('responsable_id')
                    ->label('Responsable')
                    ->relationship('responsable', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('low_stock')
                    ->label('⚠️ Bajo stock')
                    ->query(fn(Builder $query) => $query->whereColumn('stock', '<=', 'stock_minimo')),

                Filter::make('expired')
                    ->label('🚫 Vencidos')
                    ->query(fn(Builder $query) => $query->where('fecha_vencimiento', '<', now())),
            ])
            ->actions([ 
                ActionsEditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-m-pencil')
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->striped() // Añade filas cebra para mejor lectura
            ->emptyStateHeading('No hay insumos registrados')
            ->emptyStateIcon('heroicon-o-beaker');
    }
}