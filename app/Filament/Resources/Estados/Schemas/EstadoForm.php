<?php

namespace App\Filament\Resources\Estados\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput as Input;
use Filament\Forms\Components\Toggle;

class EstadoForm
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

                TextInput::make('porcentaje_avance')
                    ->label('Porcentaje de avance')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(0),

                TextInput::make('color')
                    ->label('Color (CSS o etiqueta)')
                    ->nullable(),

                Select::make('organizacion_id')
                    ->label('Organización')
                    ->relationship('organizacion', 'nombre')
                    ->nullable(),
            ]);
    }
}
