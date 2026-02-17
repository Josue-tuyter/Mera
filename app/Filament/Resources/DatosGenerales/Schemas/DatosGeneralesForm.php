<?php

namespace App\Filament\Resources\DatosGenerales\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\FusedGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class DatosGeneralesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // SECCIÓN 1: IDENTIFICACIÓN - FONDO MARRÓN CACAO
                Section::make('Identificación de la Finca')
                    ->description('Información principal y propiedad del predio.')
                    ->icon('heroicon-o-home-modern')
                    ->extraAttributes([
                        'class' => 'bg-[#4E2C0F]/5 border-t-4 border-[#4E2C0F] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        TextInput::make('nombre_finca')
                            ->label('Nombre de la Finca')
                            ->required()
                            ->maxLength(100)
                            ->regex('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/')
                            ->placeholder('Ej: Hacienda La Esperanza'),

                        TextInput::make('propietario')
                            ->label('Propietario Legal')
                            ->required()
                            ->maxLength(100)
                            ->regex('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'),

                        FusedGroup::make([
                            TextInput::make('contacto_email')
                                ->label('Email de contacto')
                                ->placeholder('ejemplo@dominio.com')
                                ->email()
                                ->rules([
                                    'nullable',
                                    'email:rfc,dns',
                                    'not_regex:/@(mailinator|tempmail|yopmail)\./i',
                                ]),

                            TextInput::make('telefono')
                                ->label('Teléfono')
                                ->tel()
                                ->placeholder('+593 ...'),
                        ]),
                    ])
                    ->columns(2),

                // SECCIÓN 2: GEOGRAFÍA - FONDO VERDE FOLLAJE
                Section::make('Ubicación y Territorio')
                    ->description('Detalles geográficos y extensión del área.')
                    ->icon('heroicon-o-map')
                    ->extraAttributes([
                        'class' => 'bg-[#606C38]/5 border-t-4 border-[#606C38] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        TextInput::make('ubicacion')
                            ->label('Dirección / Referencia')
                            ->maxLength(150)
                            ->columnSpanFull(),

                        TextInput::make('area_hectareas')
                            ->label('Área Total (ha)')
                            ->numeric()
                            ->suffix('ha')
                            ->step(0.01),

                        TextInput::make('altitud_m')
                            ->label('Altitud')
                            ->numeric()
                            ->suffix('msnm'),

                        FusedGroup::make([
                            TextInput::make('lat')
                                ->label('Latitud')
                                ->numeric()
                                ->step(0.0001)
                                ->placeholder('latitud'),

                            TextInput::make('lng')
                                ->label('Longitud')
                                ->numeric()
                                ->step(0.0001)
                                ->placeholder('longitud'),
                        ])->label('Coordenadas GPS'),
                    ])
                    ->columns(2),

                // SECCIÓN 3: TÉCNICO Y PRODUCCIÓN - FONDO AMARILLO MAZORCA
                Section::make('Especificaciones Agronómicas')
                    ->icon('heroicon-o-sparkles')
                    ->extraAttributes([
                        'class' => 'bg-[#D4A373]/5 border-t-4 border-[#D4A373] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        TextInput::make('variedad_cacao')
                            ->label('Variedad de Cacao Principal')
                            ->placeholder('Ej: CCN-51, Nacional...'),

                        TextInput::make('tipo_suelo')
                            ->label('Tipo de Suelo'),

                        TextInput::make('lluvia_media_mm')
                            ->label('Pluviometría Media')
                            ->numeric()
                            ->suffix('mm/año'),

                        Toggle::make('certificado_organico')
                            ->label('¿Posee Certificación Orgánica?')
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->inline(false),
                    ])
                    ->columns(2),

                // SECCIÓN 4: NOTAS EXTRAS
                Section::make('Observaciones Adicionales')
                    ->collapsed() // Esta sección inicia cerrada para ahorrar espacio
                    ->schema([
                        Textarea::make('notas')
                            ->label('Notas de la Finca')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}