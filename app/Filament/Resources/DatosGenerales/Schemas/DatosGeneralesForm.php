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

                        TextInput::make('nombre_finca')->label('Nombre de la finca')->required(),
                        TextInput::make('propietario')->label('Propietario')->required(),
                        TextInput::make('area_hectareas')->label('Área (ha)')->numeric()->nullable(),
                        TextInput::make('ubicacion')->label('Ubicación')->nullable(),
                        TextInput::make('lat')->label('Latitud')->numeric()->nullable(),
                        TextInput::make('lng')->label('Longitud')->numeric()->nullable(),
                        TextInput::make('tipo_suelo')->label('Tipo de suelo')->nullable(),
                        TextInput::make('variedad_cacao')->label('Variedad de cacao')->nullable(),
                        TextInput::make('altitud_m')->label('Altitud (m)')->numeric()->nullable(),
                        TextInput::make('lluvia_media_mm')->label('Lluvia media (mm)')->numeric()->nullable(),
                        TextInput::make('contacto_email')->label('Email de contacto')->email()->nullable(),
                        TextInput::make('telefono')->label('Teléfono')->tel()->nullable(),
                        Toggle::make('certificado_organico')->label('Certificado orgánico')->default(false),
                        Section::make('Notas extras')
                        ->description('Notas adicionales sobre la finca')
                            ->schema([

                                Textarea::make('notas')->label('Notas')->rows(2)->columnSpan('full'),
                            ])
                        ->secondary()
            ]);
    }
}




