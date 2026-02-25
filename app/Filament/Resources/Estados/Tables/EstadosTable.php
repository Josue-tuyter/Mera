<?php

namespace App\Filament\Resources\Estados\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Str;
use Filament\Actions\EditAction as ActionsEditAction;


class EstadosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    // Título del Estado (Sin guiones bajos)
                    TextColumn::make('nombre')
                        ->weight('bold')
                        ->size('lg')
                        ->alignCenter()
                        // Reemplaza "_" por espacio y pone la primera en mayúscula
                        ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state)))
                        ->extraAttributes([
                            'style' => 'text-transform: uppercase; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 10px;'
                        ]),

                    // Lista de Actividades (Tareas)
                    TextColumn::make('id') 
                        ->label('Tareas')
                        ->html()
                        ->formatStateUsing(function ($record) {
                            $actividades = $record->registros;

                            if (!$actividades || $actividades->isEmpty()) {
                                return '<span style="color: #94a3b8; font-style: italic;">No hay actividades aquí</span>';
                            }

                            $html = '<ul style="list-style-type: disc; margin-left: 1.5rem; text-align: left; color: #4b5563;">';
                            foreach ($actividades as $actividad) {
                                // Limpiamos el nombre de la actividad también aquí
                                $nombreLimpio = ucfirst(str_replace('_', ' ', $actividad->tipo_actividad ?? 'Sin nombre'));
                                
                                $html .= "<li style='margin-bottom: 2px; font-size: 0.9rem;'>
                                    {$nombreLimpio}
                                </li>";
                            }
                            $html .= '</ul>';
                            
                            return $html;
                        }),

                    // Badge de Avance
                    TextColumn::make('porcentaje_avance')
                        ->formatStateUsing(fn ($state) => "Avance: {$state}%")
                        ->badge()
                        ->color(fn (int $state): string => match (true) {
                            $state <= 30 => 'danger',
                            $state <= 70 => 'warning',
                            default => 'success',
                        })
                        ->alignCenter(),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->paginated(false)
            ->actions([
                ActionsEditAction::make()->label('Editar Estado')
            ]);
    }
}