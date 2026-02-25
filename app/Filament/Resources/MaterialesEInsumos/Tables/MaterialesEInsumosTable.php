<?php

namespace App\Filament\Resources\MaterialesEInsumos\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class MaterialesEInsumosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Imagen descriptiva
                ImageColumn::make('foto_insumo')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/imgs/insumo.png')) 
                    ->size(45),

                // Nombre con descripción
                TextColumn::make('nombre')
                    ->label('Material / Insumo')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary')
                    ->description(fn ($record) => $record->descripcion ? str($record->descripcion)->limit(40) : 'Sin descripción'),

                // NUEVO: Categoría (Labor) con colores distintivos
                TextColumn::make('categoria')
                    ->label('Labor / Categoría')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Poda' => 'info',
                        'Deshierba' => 'success',
                        'Fertilizacion' => 'warning',
                        'Plagas' => 'danger',
                        'Sombra' => 'gray',
                        'Riego' => 'primary',
                        default => 'gray',
                    })
                    ->sortable(),

                // NUEVO: Tipo (Herramienta vs Insumo)
                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->fontFamily('mono')
                    ->size('xs'),

                // Stock con indicador de color (Badges)
                TextColumn::make('stock')
                    ->label('Stock Actual')
                    ->sortable()
                    ->alignCenter()
                    ->weight('bold')
                    ->badge()
                    ->color(fn ($record) => 
                        $record->stock <= $record->stock_minimo ? 'danger' : 
                        ($record->stock <= $record->stock_minimo * 1.2 ? 'warning' : 'success')
                    )
                    ->formatStateUsing(fn ($state, $record) => (float)$state . " {$record->unidad}"),

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
                    ->placeholder('N/A')
                    ->toggleable(),

                // Responsable
                TextColumn::make('responsable.name')
                    ->label('Responsable')
                    ->icon('heroicon-m-user')
                    ->toggleable()
                    ->searchable(), 
            ])
            ->filters([
                // Filtro por Labor
                SelectFilter::make('categoria')
                    ->label('Filtrar por Labor')
                    ->options([
                        'Poda' => 'Poda',
                        'Deshierba' => 'Deshierba',
                        'Fertilizacion' => 'Fertilización',
                        'Plagas' => 'Control de Plagas',
                        'Sombra' => 'Manejo de Sombra',
                        'Riego' => 'Riego',
                    ]),

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
                //EditAction::make(),
                //DeleteAction::make(),
            ])
            ->bulkActions([
                // BulkActionGroup::make([
                //     //DeleteBulkAction::make(),
                // ]),
            ])
            ->striped()
            ->defaultSort('categoria') // Ordenar por labor por defecto
            ->emptyStateHeading('No hay insumos registrados')
            ->emptyStateIcon('heroicon-o-beaker');
    }
}