<?php

namespace App\Filament\Resources\RegistroDeAtividades\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use App\Models\RegistroDeAtividades;

class RegistroDeAtividadesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date()
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
                    ->searchable()
                    ->wrap(),

                // --- NUEVA COLUMNA DE MATERIALES Y CANTIDADES ---
                TextColumn::make('materiales') // Usamos la relación belongsToMany
                    ->label('Productos / Cantidad')
                    ->getStateUsing(function (RegistroDeAtividades $record) {
                        // Obtenemos los materiales cargando sus datos pivot
                        return $record->materiales->map(function ($material) {
                            // Accedemos a 'cantidad' y 'unidad_aplicada' desde el objeto pivot
                            $cantidad = $material->pivot->cantidad ?? '0';
                            $unidad = $material->pivot->unidad_aplicada ?? '';
                            
                            return "{$material->nombre}: {$cantidad} {$unidad}";
                        })->toArray();
                    })
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->searchable(query: function ($query, string $search) {
                        return $query->whereHas('materiales', function ($q) use ($search) {
                            $q->where('nombre', 'like', "%{$search}%");
                        });
                    }),
    //----------------------------------------

                TextColumn::make('organizacion.nombre')
                    ->label('Organización')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('estado.nombre')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente' => 'warning',
                        'Completado' => 'success',
                        'En Proceso' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('parcela')
                    ->label('Parcela')
                    ->toggleable(),

                TextColumn::make('duracion_minutos')
                    ->label('Duración (min)')
                    ->toggleable(),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(30)
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
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}