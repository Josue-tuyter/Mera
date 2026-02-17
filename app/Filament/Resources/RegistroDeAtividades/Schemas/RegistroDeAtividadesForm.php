<?php

namespace App\Filament\Resources\RegistroDeAtividades\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\FusedGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use App\Models\MaterialesEInsumos;

class RegistroDeAtividadesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // SECCIÓN 1: TIEMPO Y TIPO - FONDO MARRÓN CACAO
                Section::make('Planificación de la Actividad')
                    ->description('Define cuándo y qué tipo de labor se realizó.')
                    ->icon('heroicon-o-calendar-days')
                    ->extraAttributes([
                        'class' => 'bg-[#4E2C0F]/5 border-t-4 border-[#4E2C0F] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        FusedGroup::make([
                            DatePicker::make('fecha')
                                ->label('Fecha')
                                ->placeholder('Selecciona la fecha')
                                ->minDate(today())
                                ->native(false)
                                ->required(),

                            TimePicker::make('hora')
                                ->label('Hora Inicio')
                                ->nullable(),
                        ]),

                        Select::make('tipo_actividad')
                            ->label('Tipo de Actividad')
                            ->options([
                                'poda' => 'Poda',
                                'riego' => 'Riego',
                                'fertilizacion' => 'Fertilización',
                                'control_plagas' => 'Control de plagas',
                                'inspeccion' => 'Inspección',
                            ])
                            ->required()
                            ->native(false),

                        TextInput::make('duracion_minutos')
                            ->label('Duración')
                            ->numeric()
                            ->suffix('minutos')
                            ->minValue(1)
                            ->placeholder('Ej: 60'),
                    ])
                    ->columns(2),

                // SECCIÓN 2: UBICACIÓN Y RESPONSABLES - FONDO VERDE FOLLAJE
                Section::make('Ubicación y Responsables')
                    ->icon('heroicon-o-map-pin')
                    ->extraAttributes([
                        'class' => 'bg-[#606C38]/5 border-t-4 border-[#606C38] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        Select::make('encargado_id')
                            ->label('Encargado de Labor')
                            ->relationship('encargado', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('parcela')
                            ->label('Parcela / Sector')
                            ->placeholder('Ej: Lote A-1')
                            ->regex('/^[a-zA-Z0-9\\-\\/\\s]+$/'),

                        Select::make('organizacion_id')
                            ->label('Organización')
                            ->relationship('organizacion', 'nombre')
                            ->searchable()
                            ->preload(),

                        Select::make('estado_id')
                            ->label('Estado de la Actividad')
                            ->relationship('estado', 'nombre')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                // SECCIÓN 3: RECURSOS UTILIZADOS - FONDO AMARILLO MAZORCA
                Section::make('Insumos y Herramientas')
                    ->description('Registro de materiales aplicados y maquinaria usada.')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->extraAttributes([
                        'class' => 'bg-[#D4A373]/5 border-t-4 border-[#D4A373] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        Repeater::make('materiales_pivote')
                            ->label('Materiales e Insumos Aplicados')
                            ->relationship('materiales_pivote')
                            ->schema([
                                Select::make('materiales_e_insumos_id')
                                    ->label('Material / Insumo')
                                    ->options(MaterialesEInsumos::pluck('nombre', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn ($set, $state) => 
                                        $set('unidad_aplicada', MaterialesEInsumos::find($state)?->unidad)
                                    )
                                    ->columnSpan(2),

                                TextInput::make('cantidad')
                                    ->label('Cantidad')
                                    ->numeric()
                                    ->required()
                                    ->rules([
                                        fn ($get) => function (string $attribute, $value, $fail) use ($get) {
                                            $materialId = $get('materiales_e_insumos_id');
                                            if (!$materialId) return;
                                            $material = MaterialesEInsumos::find($materialId);
                                            if ($material && $value > $material->stock) {
                                                $fail("Stock insuficiente. Disponible: {$material->stock} {$material->unidad}.");
                                            }
                                        },
                                    ])
                                    ->columnSpan(1),

                                TextInput::make('unidad_aplicada')
                                    ->label('Unidad')
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(1),
                            ])
                            ->columns(4)
                            ->columnSpanFull()
                            ->itemLabel(fn (array $state): ?string => 
                                MaterialesEInsumos::find($state['materiales_e_insumos_id'])?->nombre ?? 'Nuevo Insumo'
                            ),

                        Select::make('equipos')
                            ->label('Equipos y Herramientas Utilizados')
                            ->relationship('equipos', 'nombre')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                    ]),

                // SECCIÓN 4: OBSERVACIONES
                Section::make('Observaciones Finales')
                    ->schema([
                        Textarea::make('descripcion')
                            ->label('Notas de campo')
                            ->rows(3)
                            ->placeholder('Escribe detalles adicionales sobre la actividad...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}