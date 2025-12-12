<?php

namespace App\Filament\Resources\RegistroDeAtividades\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

class RegistroDeAtividadesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->sortable(),

                TextColumn::make('hora')
                    ->label('Hora')
                    ->toggleable(),

                TextColumn::make('tipo_actividad')
                    ->label('Tipo')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('encargado.name')
                    ->label('Encargado')
                    ->sortable()
                    ->searchable()->wrap(),

                TextColumn::make('organizacion.nombre')
                    ->label('Organización')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('estado.nombre')
                    ->label('Estado')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('parcela')
                    ->label('Parcela')
                    ->toggleable(),

                TextColumn::make('producto_aplicado')
                    ->label('Producto')
                    ->toggleable(),

                TextColumn::make('cantidad_producto')
                    ->label('Cantidad')
                    ->numeric()
                    ->toggleable(),

                TextColumn::make('duracion_minutos')
                    ->label('Duración (min)')
                    ->toggleable(),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50)
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('tipo_actividad')
                    ->label('Tipo de actividad')
                    ->options([
                        'poda' => 'Poda',
                        'riego' => 'Riego',
                        'fertilizacion' => 'Fertilización',
                        'control_plagas' => 'Control de plagas',
                        'inspeccion' => 'Inspección',
                    ]),

                SelectFilter::make('estado_id')
                    ->label('Estado')
                    ->relationship('estado', 'nombre'),

                SelectFilter::make('encargado_id')
                    ->label('Encargado')
                    ->relationship('encargado', 'name'),

                Filter::make('fecha_range')
                    ->form([
                        DatePicker::make('fecha_from')->label('Desde'),
                        DatePicker::make('fecha_to')->label('Hasta'),
                    ])
                    ->query(function ($query, $data) {
                        if ($data['fecha_from'] ?? false) {
                            $query->where('fecha', '>=', $data['fecha_from']);
                        }
                        if ($data['fecha_to'] ?? false) {
                            $query->where('fecha', '<=', $data['fecha_to']);
                        }
                    }),
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
