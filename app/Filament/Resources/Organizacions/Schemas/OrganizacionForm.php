<?php

namespace App\Filament\Resources\Organizacions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class OrganizacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECCIÓN 1: Detalles Generales
                Section::make('Información General')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nombre')
                                ->label('Nombre de la Tarea/Proyecto')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            Select::make('responsable_id')
                                ->label('Asignado a')
                                ->relationship('responsable', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                        ]),
                        
                        Textarea::make('descripcion')
                            ->label('Descripción Detallada')
                            ->rows(3)
                            ->columnSpanFull(),
                            
                        Textarea::make('objetivo')
                            ->label('Objetivo Final')
                            ->placeholder('¿Qué se espera lograr con esto?')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                // SECCIÓN 2: Planificación y Estado (El cerebro del sistema)
                Section::make('Planificación y Seguimiento')
                    ->description('Gestiona los plazos y la urgencia.')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('status')
                                ->label('Estado Actual')
                                ->options([
                                    'pendiente' => 'Pendiente ⏳',
                                    'en_progreso' => 'En Progreso 🚧',
                                    'revision' => 'En Revisión 👀',
                                    'completado' => 'Completado ✅',
                                    'cancelado' => 'Cancelado 🚫',
                                ])
                                ->default('pendiente')
                                ->required()
                                ->native(false),

                            Select::make('prioridad')
                                ->label('Nivel de Prioridad')
                                ->options([
                                    'baja' => 'Baja 🟢',
                                    'media' => 'Media 🟡',
                                    'alta' => 'Alta 🔴',
                                    'urgente' => 'Urgente 🔥',
                                ])
                                ->default('media')
                                ->required()
                                ->native(false),
                        ]),

                        Grid::make(2)->schema([
                            DatePicker::make('fecha_inicio')
                                ->label('Fecha Inicio')
                                 ->minDate(today())
                                ->rules([
                                    'nullable',
                                    'date',
                                    'after_or_equal:today',
                                ])
                                ->validationMessages([
                                    'after_or_equal' => 'No se permiten fechas pasadas',
                                ])
                                ->native(false),

                            DatePicker::make('fecha_fin')
                                ->label('Fecha Vencimiento')
                                ->native(false)
                                                    ->minDate(today())
                                ->rules([
                                    'nullable',
                                    'date',
                                    'after_or_equal:fecha_inicio',
                                ])
                                ->validationMessages([
                                    'after_or_equal' => 'No se permiten fechas pasadas',
                                ])                                
                                ->suffixIcon('heroicon-m-calendar'),
                        ]),
                        
                        Toggle::make('activo')
                            ->label('Registro Visible / Activo')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->collapsible(),
            ]);
    }
}