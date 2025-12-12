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
                    ->maxLength(255),

                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->rows(3)
                    ->nullable(),

                TextInput::make('serial')
                    ->label('Serial')
                    ->nullable()
                    ->maxLength(100),

                Toggle::make('disponible')
                    ->label('Disponible')
                    ->default(true),

                DatePicker::make('fecha_ultimo_mantenimiento')
                    ->label('Último mantenimiento')
                    ->nullable(),

                DatePicker::make('proximo_mantenimiento')
                    ->label('Próximo mantenimiento')
                    ->nullable(),

                TextInput::make('intervalo_mantenimiento_dias')
                    ->label('Intervalo mantenimiento (días)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('ubicacion')->label('Ubicación')->nullable(),

                Select::make('responsable_id')
                    ->label('Responsable')
                    ->relationship('responsable', 'name')
                    ->nullable(),

                TextInput::make('costo_mantenimiento_estimado')
                    ->label('Costo mantenimiento estimado')
                    ->numeric()
                    ->nullable(),
            ]);
    }
}
