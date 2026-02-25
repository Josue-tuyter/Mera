<?php

namespace App\Filament\Resources\Organizacions\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\EditAction;
use Carbon\Carbon;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\Action;
use Filament\Actions\BulkActionGroup;




class OrganizacionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Columna de Prioridad con Icono y Color
                TextColumn::make('prioridad')
                    ->label('Prioridad')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'baja' => 'gray',
                        'media' => 'info',
                        'alta' => 'warning',
                        'urgente' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'urgente' => 'heroicon-o-fire',
                        'alta' => 'heroicon-o-exclamation-triangle',
                        default => 'heroicon-o-minus',
                    })
                    ->sortable(),

                TextColumn::make('nombre')
                    ->label('Actividad')
                    ->searchable()
                    ->weight('bold') // Negrita para destacar
                    ->description(fn ($record) => \Illuminate\Support\Str::limit($record->descripcion, 40)),

                // Badge de Estado
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'gray',
                        'en_progreso' => 'warning',
                        'revision' => 'info',
                        'completado' => 'success',
                        'cancelado' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('responsable.name')
                    ->label('Responsable')
                    ->icon('heroicon-o-user')
                    ->searchable()
                    ->toggleable(),

                // Fecha Fin con lógica de alerta
                TextColumn::make('fecha_fin')
                    ->label('Vencimiento')
                    ->date('d M Y')
                    ->sortable()
                    ->color(function ($record) {
                        // Si ya pasó la fecha y NO está completado, poner en rojo
                        if ($record->fecha_fin < now() && $record->status !== 'completado') {
                            return 'danger';
                        }
                        return null;
                    })
                    ->icon(function ($record) {
                        if ($record->fecha_fin < now() && $record->status !== 'completado') {
                            return 'heroicon-o-exclamation-circle';
                        }
                        return 'heroicon-o-calendar';
                    }),

                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Oculto por defecto para limpiar la vista
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Filtrar por Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'en_progreso' => 'En Progreso',
                        'completado' => 'Completado',
                    ]),

                SelectFilter::make('prioridad')
                    ->label('Prioridad')
                    ->options([
                        'alta' => 'Alta / Urgente',
                        'media' => 'Media',
                        'baja' => 'Baja',
                    ]),

                SelectFilter::make('responsable_id')
                    ->label('Responsable')
                    ->relationship('responsable', 'name'),

                Filter::make('vencidas')
                    ->label('Solo Tareas Vencidas')
                    ->query(fn ($query) => $query->where('fecha_fin', '<', now())->where('status', '!=', 'completado'))
                    ->toggle(),
            ])
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
    }
}