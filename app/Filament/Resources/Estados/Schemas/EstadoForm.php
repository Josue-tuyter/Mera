<?php

namespace App\Filament\Resources\Estados\Schemas;

use Filament\Forms\Form; // Importantec
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Slider;
use Filament\Schemas\Schema;



class EstadoForm
{
    public static function configure(Schema $schema): array
    {
        return [
            TextInput::make('nombre')
                ->label('Nombre del Estado')
                ->required()
                ->maxLength(255),

            Textarea::make('descripcion')
                ->label('Descripción')
                ->rows(2),

            Slider::make('porcentaje_avance')
                ->label('Progreso (%)')
                ->minValue(0)
                ->maxValue(100)
                ->default(0),

            ColorPicker::make('color')
                ->label('Color Visual'),

            Select::make('organizacion_id')
                ->label('Organización')
                ->relationship('organizacion', 'nombre')
                ->nullable(),
        ];
    }
}