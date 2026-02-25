<?php

namespace App\Filament\Resources\MaterialesEInsumos\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;

class MaterialesEInsumosForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Tabs')
                ->tabs([
                    // PESTAÑA 1: CLASIFICACIÓN (Poda, Riego, etc)
                    Tabs\Tab::make('Clasificación y Labor')
                        ->icon('heroicon-m-tag')
                        ->schema([
                            Section::make('Categorización del Material')
                                ->description('Define a qué labor pertenece este elemento.')
                                ->extraAttributes(['class' => 'bg-[#4E2C0F]/5 border-t-4 border-[#4E2C0F] rounded-xl'])
                                ->schema([
                                    Select::make('categoria')
                                        ->label('Labor Asociada')
                                        ->options([
                                            'Poda' => '1. Poda (Ramas/Chupones)',
                                            'Deshierba' => '2. Deshierba / Limpieza',
                                            'Fertilizacion' => '3. Fertilización',
                                            'Plagas' => '4. Control de Plagas',
                                            'Sombra' => '5. Manejo de Sombra',
                                            'Riego' => '6. Riego',
                                        ])
                                        ->required()
                                        ->searchable(),

                                    Select::make('tipo')
                                        ->label('Tipo de Elemento')
                                        ->options([
                                            'Herramienta' => 'Herramienta (Activo)',
                                            'Insumo' => 'Insumo (Consumible)',
                                            'EPP' => 'Equipo de Protección (EPP)',
                                            'Recurso' => 'Recurso Natural (Agua/Otros)',
                                        ])
                                        ->required(),

Select::make('nombre')
    ->label('Nombre del Material / Insumo')
    ->placeholder('Seleccione un elemento de la lista')
    ->required()
    ->searchable() // Permite escribir para filtrar la lista
    ->options([
        'Herramientas de Poda' => [
            'tijera_corta' => 'Tijera corta de poda',
            'tijera_larga' => 'Tijera larga de poda',
            'serrucho_podon' => 'Podón o serrucho',
        ],
        'Limpieza y Deshierba' => [
            'machete' => 'Machete',
            'azadon' => 'Azadón',
            'botas_caucho' => 'Botas de caucho',
        ],
        'Insumos y Fertilizantes' => [
            'urea' => 'Urea agrícola',
            'npk' => 'Fertilizante NPK',
            'abono_organico' => 'Abono orgánico',
            'biolep' => 'Biolep 2X',
        ],
        'Equipos y Otros' => [
            'balde' => 'Balde',
            'pala' => 'Pala',
            'bomba_fumigacion' => 'Bomba de fumigación',
            'mascarilla' => 'Mascarilla',
            'gafas' => 'Gafas de protección',
            'manguera' => 'Manguera',
        ],
        'Protección' => [
            'guantes' => 'Guantes (Par)',
        ],
    ])
    ->native(false) // Hace que se vea mucho más moderno y uniforme
                                ])->columns(2),
                        ]),

                    // PESTAÑA 2: INVENTARIO
                    Tabs\Tab::make('Inventario')
                        ->icon('heroicon-m-archive-box')
                        ->schema([
                            Section::make('Control de Existencias')
                                ->extraAttributes(['class' => 'bg-[#606C38]/5 border-t-4 border-[#606C38] rounded-xl'])
                                ->schema([
                                    TextInput::make('stock')
                                        ->label('Cantidad Actual')
                                        ->numeric()
                                        ->default(0)
                                        ->required(),

                                    Select::make('unidad')
                                        ->label('Unidad de Medida')
                                        ->options([
                                            'unidad' => 'Unidad (Und)',
                                            'par' => 'Par',
                                            'kg' => 'Kilogramos (Kg)',
                                            'litros' => 'Litros (Lts)',
                                            'recurso' => 'Recurso',
                                        ])
                                        ->required(),

                                    TextInput::make('stock_minimo')
                                        ->label('Alerta Stock Mínimo')
                                        ->numeric()
                                        ->helperText('Notificar cuando baje de esta cantidad.')
                                        ->columnSpanFull(),
                                ])->columns(2),
                        ]),

                    // PESTAÑA 3: LOGÍSTICA
                    Tabs\Tab::make('Responsable y Fechas')
                        ->icon('heroicon-m-truck')
                        ->schema([
                            Section::make('Datos Logísticos')
                                ->extraAttributes(['class' => 'bg-[#D4A373]/5 border-t-4 border-[#D4A373] rounded-xl'])
                                ->schema([
                                    Select::make('responsable_id')
                                        ->relationship('responsable', 'name')
                                        ->label('Encargado')
                                        ->required(),

                                    TextInput::make('proveedor')
                                        ->label('Proveedor'),

                                    DatePicker::make('fecha_vencimiento')
                                        ->label('Vencimiento (Si aplica)')
                                        ->native(false),

                                    Textarea::make('descripcion')
                                        ->label('Notas de uso')
                                        ->columnSpanFull(),
                                ])->columns(2),
                        ]),
                ])
                ->columnSpanFull()
        ]);
    }
}