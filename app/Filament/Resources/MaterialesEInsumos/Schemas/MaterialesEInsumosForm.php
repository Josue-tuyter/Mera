<?php

namespace App\Filament\Resources\MaterialesEInsumos\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\FusedGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;

class MaterialesEInsumosForm
{
    protected static function getNombreRegex(): string 
    {
        return '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/';
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                
                // SECCIÓN 1: IDENTIFICACIÓN - FONDO MARRÓN CACAO
                Section::make('Información del Material')
                    ->description('Datos generales y descripción del insumo.')
                    ->icon('heroicon-o-beaker')
                    ->extraAttributes([
                        'class' => 'bg-[#4E2C0F]/5 border-t-4 border-[#4E2C0F] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        Group::make([
                            TextInput::make('nombre')
                                ->label('Nombre del Insumo')
                                ->required()
                                ->maxLength(100)
                                ->regex(self::getNombreRegex())
                                ->validationMessages([
                                    'regex' => 'Solo se permiten letras y espacios',
                                ])
                                ->columnSpanFull(),

                            Textarea::make('descripcion')
                                ->label('Descripción Detallada')
                                ->rows(3)
                                ->maxLength(500)
                                ->helperText('Describe brevemente para qué se utiliza este material.')
                                ->columnSpanFull(),
                        ])->columnSpan(2),
                    ])
                    ->columns(2),

                // SECCIÓN 2: INVENTARIO - FONDO VERDE FOLLAJE
                Section::make('Control de Inventario')
                    ->description('Gestión de cantidades y unidades.')
                    ->icon('heroicon-o-archive-box')
                    ->extraAttributes([
                        'class' => 'bg-[#606C38]/5 border-t-4 border-[#606C38] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        // Aquí usamos el FusedGroup que te gustó
                        FusedGroup::make([
                            TextInput::make('stock')
                                ->label('Stock Actual')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->prefixIcon('heroicon-m-circle-stack'),

                            TextInput::make('unidad')
                                ->label('Unidad de Medida')
                                ->placeholder('Ej: Kg, Lts, Und')
                                ->required()
                                ->regex(self::getNombreRegex()),
                        ])->columnSpan(1),

                        TextInput::make('stock_minimo')
                            ->label('Alerta Stock Mínimo')
                            ->numeric()
                            ->minValue(0)
                            ->placeholder('0')
                            ->helperText('Se notificará cuando el stock sea igual o menor.')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                // SECCIÓN 3: LOGÍSTICA Y FECHAS - FONDO AMARILLO MAZORCA
                Section::make('Gestión y Logística')
                    ->icon('heroicon-o-truck')
                    ->extraAttributes([
                        'class' => 'bg-[#D4A373]/5 border-t-4 border-[#D4A373] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        Select::make('responsable_id')
                            ->label('Responsable / Encargado')
                            ->relationship('responsable', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('proveedor')
                            ->label('Proveedor Principal')
                            ->maxLength(100)
                            ->nullable(),

                        FusedGroup::make([
                            TextInput::make('lote')
                                ->label('Lote')
                                ->placeholder('N° Lote'),

                            DatePicker::make('fecha_vencimiento')
                                ->label('Vencimiento')
                                ->native(false)
                                ->minDate(today())
                                ->validationMessages([
                                    'min_date' => 'No se permiten productos ya vencidos',
                                ]),
                        ]),

                        Placeholder::make('creado_en')
                            ->label('Fecha de Registro')
                            ->content(fn ($record) => $record ? $record->created_at->format('d/m/Y H:i') : 'Nuevo registro'),
                    ])
                    ->columns(2),
            ]);
    }
}