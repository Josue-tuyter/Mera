<?php

namespace App\Filament\Resources\Estados\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Slider;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class EstadoForm
{
    public static function configure(Schema $schema): array
    {
        return [
            // SECCIÓN 1: IDENTIDAD Y ESTÉTICA - MARRÓN CACAO
            Section::make('Definición del Estado')
                ->description('Configura el nombre, la descripción y el color identificativo.')
                ->icon('heroicon-o-swatch')
                ->extraAttributes([
                    'class' => 'bg-[#4E2C0F]/5 border-t-4 border-[#4E2C0F] rounded-xl shadow-sm',
                ])
                ->schema([
                    TextInput::make('nombre')
                        ->label('Nombre del Estado')
                        ->placeholder('Ej: Planificado, En Curso, Detenido...')
                        ->required()
                        ->maxLength(255),

                    ColorPicker::make('color')
                        ->label('Color Visual')
                        ->default('#4E2C0F')
                        ->helperText('Este color se usará para resaltar el estado en tablas y reportes.'),

                    Textarea::make('descripcion')
                        ->label('Descripción del Estado')
                        ->placeholder('Explica brevemente qué significa este estado...')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            // SECCIÓN 2: MÉTRICAS Y ASIGNACIÓN - VERDE FOLLAJE
            Section::make('Progreso y Pertenencia')
                ->description('Define el impacto en el avance total y la organización responsable.')
                ->icon('heroicon-o-presentation-chart-line')
                ->extraAttributes([
                    'class' => 'bg-[#606C38]/5 border-t-4 border-[#606C38] rounded-xl shadow-sm',
                ])
                ->schema([
                Slider::make('porcentaje_avance')
                    // El label se actualiza en tiempo real mientras mueves el slider
                    ->label(fn ($state) => "Progreso actual: " . ($state ?? 0) . "%")
                    ->helperText('Desliza para ajustar el avance de este estado.')
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(1)
                    ->default(0)
                    ->live() // Esto es lo que permite que el label cambie mientras mueves el mouse
                    ->columnSpanFull(),

                    // Select::make('organizacion_id')
                    //     ->label('Organización Relacionada')
                    //     ->relationship('organizacion', 'nombre')
                    //     ->prefixIcon('heroicon-m-building-library')
                    //     ->searchable()
                    //     ->preload()
                    //     ->nullable()
                    //     ->columnSpanFull(),
                ])
                ->columns(1),
        ];
    }
}