<?php

namespace App\Filament\Resources\Organizacions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use App\Models\User;

class OrganizacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->rows(4)
                    ->nullable(),

                Select::make('responsable_id')
                    ->label('Responsable')
                    ->relationship('responsable', 'name')
                    ->searchable()
                    ->nullable(),

                DatePicker::make('fecha_inicio')
                    ->label('Fecha de inicio')
                    ->nullable(),

                DatePicker::make('fecha_fin')
                    ->label('Fecha fin')
                    ->nullable(),

                Textarea::make('objetivo')
                    ->label('Objetivo')
                    ->rows(3)
                    ->nullable(),

                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true),
            ]);
    }
}
