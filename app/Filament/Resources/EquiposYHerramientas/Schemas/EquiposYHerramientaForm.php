<?php

namespace App\Filament\Resources\EquiposYHerramientas\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;

class EquiposYHerramientaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                
                // SECCIÓN 1: IDENTIFICACIÓN
                Section::make('Identificación del Equipo')
                    ->description('Escribe los datos del equipo.')
                    ->icon('heroicon-o-identification')
                    ->extraAttributes([
                        'class' => 'bg-[#4E2C0F]/5 border-t-4 border-[#4E2C0F] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        Group::make([
                            TextInput::make('nombre')
                                ->label('Nombre')
                                ->required()
                                ->maxLength(100)
                                // VALIDACIÓN DE UNICIDAD: evita nombres duplicados
                                ->unique(ignoreRecord: true)
                                ->regex('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/')
                                ->validationMessages([
                                    'regex' => 'Solo se permiten letras, espacios y guiones',
                                    'unique' => 'Ya existe un equipo registrado con este nombre',
                                ])
                                ->live(onBlur: true),

                            TextInput::make('serial')
                                ->label('Serial')
                                ->nullable()
                                ->maxLength(50)
                                // VALIDACIÓN DE UNICIDAD: evita seriales duplicados
                                ->unique(ignoreRecord: true)
                                ->regex('/^[a-zA-Z0-9\-\/]+$/')
                                ->validationMessages([
                                    'regex' => 'Solo se permiten letras, números, guiones y barras',
                                    'unique' => 'Este número de serial ya está asignado a otro equipo',
                                ])
                                ->live(onBlur: true),
                        ])->columnSpan(2),
                    ])
                    ->columns(2),

                // SECCIÓN 2: UBICACIÓN
                Section::make('Ubicación y Gestión')
                    ->icon('heroicon-o-map-pin')
                    ->extraAttributes([
                        'class' => 'bg-[#606C38]/5 border-t-4 border-[#606C38] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        TextInput::make('ubicacion')
                            ->label('Ubicación')
                            ->maxLength(100)
                            ->placeholder('Ej: Bodega Principal'),

                        Select::make('responsable_id')
                            ->label('Responsable')
                            ->relationship('responsable', 'name')
                            ->searchable()
                            ->preload(),

                        Textarea::make('descripcion')
                            ->label('Descripción Detallada')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // SECCIÓN 3: MANTENIMIENTO
                Section::make('Control de Mantenimiento')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->extraAttributes([
                        'class' => 'bg-[#D4A373]/5 border-t-4 border-[#D4A373] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        DatePicker::make('fecha_ultimo_mantenimiento')
                            ->label('Último mantenimiento')
                            ->native(false),

                        TextInput::make('intervalo_mantenimiento_dias')
                            ->label('Intervalo mantenimiento (días)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(9999),

                        TextInput::make('costo_mantenimiento_estimado')
                            ->label('Costo mantenimiento estimado')
                            ->numeric()
                            ->prefix('$')
                            ->suffix('USD')
                            ->step(0.01),
                    ])
                    ->columns(1),

                // SECCIÓN 4: ESTADO
                Section::make()
                    ->schema([
                        Toggle::make('disponible')
                            ->label('¿El equipo está operativo actualmente?')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),
                    ]),
            ]);
    }
}