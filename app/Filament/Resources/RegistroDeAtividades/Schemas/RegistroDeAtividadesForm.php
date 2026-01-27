<?php

namespace App\Filament\Resources\RegistroDeAtividades\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\MultiSelect;
use App\Models\EquiposYHerramienta;
use App\Models\MaterialesEInsumos;

class RegistroDeAtividadesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('fecha')->label('Fecha')->required(),
                TimePicker::make('hora')->label('Hora')->nullable(),

                Select::make('tipo_actividad')
                    ->label('Tipo de actividad')
                    ->options([
                        'poda' => 'Poda',
                        'riego' => 'Riego',
                        'fertilizacion' => 'Fertilización',
                        'control_plagas' => 'Control de plagas',
                        'inspeccion' => 'Inspección',
                    ])
                    ->required(),

                Select::make('encargado_id')
                    ->label('Encargado')
                    ->relationship('encargado', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Select::make('organizacion_id')
                    ->label('Organización')
                    ->relationship('organizacion', 'nombre')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Select::make('estado_id')
                    ->label('Estado')
                    ->relationship('estado', 'nombre')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                TextInput::make('duracion_minutos')
                    ->label('Duración (minutos)')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(1440)
                    ->nullable(),

                TextInput::make('parcela')
                    ->label('Parcela')
                    ->maxLength(50)
                    ->regex('/^[a-zA-Z0-9\\-\\/\\s]+$/')
                    ->validationMessages([
                        'regex' => 'Solo se permiten letras, números, guiones, barras y espacios',
                    ])
                    ->live()
                    ->nullable(),

                TextInput::make('producto_aplicado')
                    ->label('Producto aplicado')
                    ->maxLength(100)
                    ->regex('/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\-,.]+$/')
                    ->validationMessages([
                        'regex' => 'Solo se permiten letras, números, espacios y caracteres especiales básicos',
                    ])
                    ->live()
                    ->nullable(),

                TextInput::make('cantidad_producto')
                    ->label('Cantidad producto')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(99999.99)
                    ->step(0.01)
                    ->nullable(),

                TextInput::make('unidad')
                    ->label('Unidad')
                    ->maxLength(30)
                    ->regex('/^[a-zA-Z\\s\\-]+$/')
                    ->validationMessages([
                        'regex' => 'Solo se permiten letras, espacios y guiones',
                    ])
                    ->live()
                    ->nullable(),

                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->maxLength(500)
                    ->rows(4)
                    ->columnSpan('full')
                    ->nullable()
                    ->helperText('Máximo 500 caracteres'),

                MultiSelect::make('equipos')
                    ->label('Equipos y herramientas')
                    ->relationship('equipos', 'nombre')
                    ->helperText('Selecciona los equipos/herramientas utilizados')
                    ->preload(),

                MultiSelect::make('materiales')
                    ->label('Materiales e insumos')
                    ->relationship('materiales', 'nombre')
                    ->helperText('Selecciona materiales/insumos usados (detalle de cantidad en pivots)')
                    ->preload(),
            ]);
    }
}
