<?php

namespace App\Filament\Resources\DatosGenerales\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Schemas\Components\Section;

class DatosGeneralesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre_finca')
                    ->label('Nombre de la finca')
                    ->required()
                    ->maxLength(100)
                    ->regex('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/')
                    ->validationMessages([
                        'regex' => 'Solo se permiten letras, espacios y guiones',
                    ])
                    ->live(),

                TextInput::make('propietario')
                    ->label('Propietario')
                    ->required()
                    ->maxLength(100)
                    ->regex('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/')
                    ->validationMessages([
                        'regex' => 'El propietario solo puede contener letras y espacios',
                    ])
                    ->live(),

                TextInput::make('area_hectareas')
                    ->label('Área (ha)')
                    ->numeric()
                    ->minValue(0.1)
                    ->maxValue(99999.99)
                    ->step(0.01)
                    ->nullable(),

                TextInput::make('ubicacion')
                    ->label('Ubicación')
                    ->maxLength(150)
                    ->nullable(),

                TextInput::make('lat')
                    ->label('Latitud')
                    ->numeric()
                    ->minValue(-90)
                    ->maxValue(90)
                    ->step(0.0001)
                    ->nullable(),

                TextInput::make('lng')
                    ->label('Longitud')
                    ->numeric()
                    ->minValue(-180)
                    ->maxValue(180)
                    ->step(0.0001)
                    ->nullable(),

                TextInput::make('tipo_suelo')
                    ->label('Tipo de suelo')
                    ->maxLength(50)
                    ->regex('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/')
                    ->validationMessages([
                        'regex' => 'Solo se permiten letras, espacios y guiones',
                    ])
                    ->nullable(),

                TextInput::make('variedad_cacao')
                    ->label('Variedad de cacao')
                    ->maxLength(50)
                    ->regex('/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\-]+$/')
                    ->validationMessages([
                        'regex' => 'Solo se permiten letras, números, espacios y guiones',
                    ])
                    ->nullable(),

                TextInput::make('altitud_m')
                    ->label('Altitud (m)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(8848)
                    ->nullable(),

                TextInput::make('lluvia_media_mm')
                    ->label('Lluvia media (mm)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(99999)
                    ->nullable(),

                TextInput::make('contacto_email')
                    ->label('Email de contacto')
                    ->maxLength(100)
                    ->nullable()
                    ->live(onBlur: true)
                    ->rules([
                        'nullable',
                        'email:rfc,dns',
                        'not_regex:/@(mailinator|tempmail|guerrillamail|10minutemail|yopmail|dispostable|throwawaymail|fakeinbox|sharklasers|getnada)\./i',
                    ])
                    ->validationMessages([
                        'email' => 'El correo electrónico no tiene un formato válido o el dominio no existe',
                        'not_regex' => 'No se permiten correos temporales',
                    ]) ,


                TextInput::make('telefono')
                    ->label('Teléfono')
                    ->tel()
                    ->regex('/^[0-9\+\-\s\(\)]+$/')
                    ->maxLength(20)
                    ->validationMessages([
                        'regex' => 'El teléfono solo puede contener números, +, - y espacios',
                    ])
                    ->live()
                    ->nullable(),

                Toggle::make('certificado_organico')
                    ->label('Certificado orgánico')
                    ->default(false),

                Section::make('Notas extras')
                    ->description('Notas adicionales sobre la finca')
                    ->schema([
                        Textarea::make('notas')
                            ->label('Notas')
                            ->maxLength(500)
                            ->rows(3)
                            ->nullable()
                            ->helperText('Máximo 500 caracteres'),
                    ])
                    ->secondary()
            ]);
    }
}




