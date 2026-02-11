<?php

namespace App\Filament\Resources\EquiposYHerramientas\Schemas;

use Filament\Schemas\Schema;
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
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(100)
                    ->regex('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/')
                    ->validationMessages([
                        'regex' => 'Solo se permiten letras, espacios y guiones',
                    ])
                    ->live(),

                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->maxLength(500)
                    ->rows(3)
                    ->nullable()
                    ->helperText('Máximo 500 caracteres'),

                TextInput::make('serial')
                    ->label('Serial')
                    ->nullable()
                    ->maxLength(50)
                    ->regex('/^[a-zA-Z0-9\-\/]+$/')
                    ->validationMessages([
                        'regex' => 'Solo se permiten letras, números, guiones y barras',
                    ])
                    ->live(),

                Toggle::make('disponible')
                    ->label('Disponible')
                    ->default(true),

                DatePicker::make('fecha_ultimo_mantenimiento')
                    ->label('Último mantenimiento')
                    ->nullable()
                    ->native(false)
                    ->minDate(now()->subDay())
                    ->rules([
                        'nullable',
                        'date',
                        'after_or_equal:yesterday',
                    ])
                    ->validationMessages([
                        'after_or_equal' => 'No se permiten fechas anteriores a ayer',
                    ]),

                DatePicker::make('proximo_mantenimiento')
                    ->label('Próximo mantenimiento')
                    ->nullable()
                    ->reactive()
                    ->native(false)
                    ->minDate(today())
                    ->rules([
                        'nullable',
                        'date',
                        'after_or_equal:today',
                    ])
                    ->validationMessages([
                        'after_or_equal' => 'No se permiten fechas pasadas',
                    ]),
                TextInput::make('intervalo_mantenimiento_dias')
                    ->label('Intervalo mantenimiento (días)')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(9999)
                    ->nullable()
                    ->visible(fn ($get) => $get('proximo_mantenimiento') !== null),

                TextInput::make('ubicacion')
                    ->label('Ubicación')
                    ->maxLength(100)
                    ->nullable(),

                Select::make('responsable_id')
                    ->label('Responsable')
                    ->relationship('responsable', 'name')
                    ->nullable(),

                TextInput::make('costo_mantenimiento_estimado')
                    ->label('Costo mantenimiento estimado')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(999999.99)
                    ->step(0.01)
                    ->suffix('USD')
                    ->nullable(),
            ]);
    }

    
}
