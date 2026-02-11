<?php

namespace App\Filament\Resources\RegistroDeAtividades\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use App\Models\MaterialesEInsumos;




use Filament\Forms\Components\MultiSelect;

class RegistroDeAtividadesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('fecha')
                    ->label('Fecha')
                    ->minDate(today())
                    ->rules([
                        'nullable',
                        'date',
                        'after_or_equal:today',
                    ])
                    ->validationMessages([
                        'after_or_equal' => 'No se permiten fechas pasadas',
                    ])
                    ->native(false)
                    ->required(),

                TimePicker::make('hora')
                    ->label('Hora')
                    ->nullable(),

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
                    ->nullable(),

                /** 🔹 MATERIALES E INSUMOS (PIVOT) */

Repeater::make('materiales_pivote') // <--- Usamos la nueva relación hasMany
    ->label('Materiales e insumos usados')
    ->relationship('materiales_pivote')
    ->schema([
        Select::make('materiales_e_insumos_id')
            ->label('Material / Insumo')
            ->options(MaterialesEInsumos::pluck('nombre', 'id'))
            ->searchable()
            ->required()
            ->reactive()
            ->afterStateUpdated(function ($set, $state) {
                $material = MaterialesEInsumos::find($state);
                if ($material) {
                    $set('unidad_aplicada', $material->unidad);
                }
            }),

        TextInput::make('cantidad')
            ->label('Cantidad usada')
            ->numeric()
            ->required()
            ->rules([
                fn ($get) => function (string $attribute, $value, $fail) use ($get) {
                    $materialId = $get('materiales_e_insumos_id');
                    if (!$materialId) return;

                    $material = \App\Models\MaterialesEInsumos::find($materialId);
                    if ($material && $value > $material->stock) {
                        $fail("No hay suficiente stock. Disponible: {$material->stock} {$material->unidad}.");
                    }
                },
            ]),

        TextInput::make('unidad_aplicada')
            ->label('Unidad')
            ->disabled()
            ->dehydrated()
            ->required(),
    ])
    ->columnSpan('full')
    ,



                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->maxLength(500)
                    ->rows(4)
                    ->columnSpan('full')
                    ->nullable()
                    ->helperText('Máximo 500 caracteres'),

                Select::make('equipos')
                    ->label('Equipos y herramientas')
                    ->relationship('equipos', 'nombre')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->helperText('Selecciona los equipos/herramientas utilizados'),
            ]);
    }
}
