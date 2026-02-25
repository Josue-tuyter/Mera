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
use App\Models\RegistroDeAtividades;

class RegistroDeAtividadesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                    // SECCIÓN 1: TIEMPO Y TIPO
                    Section::make('Planificación de la Actividad')
                        ->description('Define el horario y tipo de labor realizada.')
                        ->icon('heroicon-o-calendar-days')
                        ->extraAttributes([
                            'class' => 'bg-[#4E2C0F]/5 border-t-4 border-[#4E2C0F] rounded-xl shadow-sm',
                        ])
                        ->schema([
                            // Campo de fecha ocupa toda la fila o mitad según desees
                            DatePicker::make('fecha')
                                ->label('Fecha de la Actividad')
                                ->placeholder('Selecciona la fecha')
                                ->native(false)
                                ->required()
                                ->live()
                                ->minDate(today()) 
                                    ->validationMessages([
                                        'min_date' => 'No puedes seleccionar una fecha anterior a hoy.',
                                    ])
                                ->columnSpan(2), // Ocupa el ancho completo de la sección

                            // Grupo de Horas: Inicio y Fin
                            TimePicker::make('hora_inicio')
                                ->label('Hora Inicio')
                                ->default('07:00')
                                ->seconds(false)
                                ->required()
                                ->native(false)
                                ->live(),

                            TimePicker::make('hora_fin')
                                ->label('Hora Fin')
                                ->seconds(false)
                                ->required()
                                ->native(false)
                                ->live()
                                // Validación para asegurar que la hora fin sea después de la inicio
                                ->after('hora_inicio')
                                ->validationMessages([
                                    'after' => 'La hora de fin debe ser posterior a la de inicio',
                                    'required' => 'La hora de fin es obligatoria',
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
                                ->native(false)
                                ->live()
                                ->columnSpan(2) // Ocupa el ancho completo
                                ->rules([
                                    fn ($get) => function (string $attribute, $value, $fail) use ($get) {
                                        $fecha = $get('fecha');
                                        $parcela = $get('parcela');
                                        
                                        if (!$fecha || !$parcela || !$value) return;

                                        $existe = RegistroDeAtividades::where('fecha', $fecha)
                                            ->where('parcela', $parcela)
                                            ->where('tipo_actividad', $value)
                                            ->when($get('id'), fn($query, $id) => $query->where('id', '!=', $id))
                                            ->exists();

                                        if ($existe) {
                                            $fail("Ya existe una actividad de '{$value}' registrada para la parcela '{$parcela}' en esta fecha.");
                                        }
                                    },
                                ]),
                        ])
                        ->columns(2),

                // SECCIÓN 2: UBICACIÓN Y RESPONSABLES
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
                            ->label('Lote')
                            ->placeholder('Ej: 1')
                            ->live()
                            ->required()
                            ->numeric()
                            // --- ESTAS SON LAS LÍNEAS QUE DEBES AÑADIR ---
                            ->minValue(1) // No permite números menores a 1 (adiós negativos y cero)
                            ->validationMessages([
                                'min' => 'El número de lote debe ser al menos 1.',
                            ]),

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

                // SECCIÓN 3: RECURSOS UTILIZADOS
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
                                    // ESTO EVITA REPETIR EL MISMO MATERIAL EN EL REPEATER
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
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