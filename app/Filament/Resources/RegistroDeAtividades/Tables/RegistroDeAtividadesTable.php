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
use Filament\Tables\Columns\IconColumn;

class RegistroDeAtividadesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Fecha y Hora combinadas visualmente
                TextColumn::make('fecha')
                    ->label('Programación')
                    ->date('d/m/Y')
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => "Hora: " . ($record->hora ?? '--:--')),

                // Tipo de Actividad con Iconos específicos
                TextColumn::make('tipo_actividad')
                    ->label('Actividad')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->icon(fn ($state): string => match ($state) {
                        'poda' => 'heroicon-m-scissors',
                        'riego' => 'heroicon-m-beaker',
                        'fertilizacion' => 'heroicon-m-sparkles',
                        'control_plagas' => 'heroicon-m-shield-exclamation',
                        'inspeccion' => 'heroicon-m-magnifying-glass',
                        default => 'heroicon-m-clipboard-document-list',
                    })
                    ->color('primary'),

                // Encargado con Avatar de Iniciales
                TextColumn::make('encargado.name')
                    ->label('Responsable')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-user-circle')
                    ->wrap(),

                // SECCIÓN DE MATERIALES MEJORADA
                TextColumn::make('materiales')
                    ->label('Insumos Aplicados')
                    ->getStateUsing(function (RegistroDeAtividades $record) {
                        return $record->materiales->map(function ($material) {
                            $cantidad = $material->pivot->cantidad ?? '0';
                            $unidad = $material->pivot->unidad_aplicada ?? '';
                            return "{$material->nombre} ({$cantidad} {$unidad})";
                        })->toArray();
                    })
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->badge() // Los ponemos como badges para que resalten individualmente
                    ->color('gray')
                    ->searchable(query: function ($query, string $search) {
                        return $query->whereHas('materiales', function ($q) use ($search) {
                            $q->where('nombre', 'like', "%{$search}%");
                        });
                    }),

                // Estado con Badge y Colores dinámicos
                TextColumn::make('estado.nombre')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente' => 'warning',
                        'Completado' => 'success',
                        'En Proceso' => 'info',
                        'Cancelado' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Pendiente' => 'heroicon-m-clock',
                        'Completado' => 'heroicon-m-check-circle',
                        'En Proceso' => 'heroicon-m-arrow-path',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->sortable(),

                // Datos de ubicación y esfuerzo
                TextColumn::make('parcela')
                    ->label('Ubicación')
                    ->icon('heroicon-m-map-pin')
                    ->description(fn ($record) => "Parcela: " . ($record->parcela ?? 'N/A'))
                    ->toggleable()
                    ->label('Detalles'),

                TextColumn::make('duracion_minutos')
                    ->label('Duración')
                    ->suffix(' min')
                    ->alignRight()
                    ->toggleable(),

                TextColumn::make('descripcion')
                    ->label('Notas')
                    ->limit(25)
                    ->tooltip(fn ($state) => $state) // Muestra el texto completo al pasar el mouse
                    ->wrap()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tipo_actividad')
                    ->label('Filtrar por Tipo')
                    ->options([
                        'poda' => 'Poda',
                        'riego' => 'Riego',
                        'fertilizacion' => 'Fertilización',
                        'control_plagas' => 'Control de plagas',
                        'inspeccion' => 'Inspección',
                    ]),

                SelectFilter::make('estado_id')
                    ->label('Estado actual')
                    ->relationship('estado', 'nombre')
                    ->preload(),

                SelectFilter::make('encargado_id')
                    ->label('Por Encargado')
                    ->relationship('encargado', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('fecha_range')
                    ->label('Rango de fechas')
                    ->form([
                        DatePicker::make('fecha_from')->label('Desde')->native(false),
                        DatePicker::make('fecha_to')->label('Hasta')->native(false),
                    ])
                    ->query(function ($query, $data) {
                        return $query
                            ->when($data['fecha_from'], fn ($q) => $q->where('fecha', '>=', $data['fecha_from']))
                            ->when($data['fecha_to'], fn ($q) => $q->where('fecha', '<=', $data['fecha_to']));
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->defaultSort('fecha', 'desc');
    }
}