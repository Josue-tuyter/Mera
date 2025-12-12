<?php

namespace App\Filament\Resources\MaterialesEInsumos\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;

class MaterialesEInsumosForm
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
                    ->rows(3)
                    ->nullable(),

                TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->required()
                    ->default(0),

                TextInput::make('unidad')
                    ->label('Unidad')
                    ->nullable()
                    ->maxLength(50),

                TextInput::make('stock_minimo')
                    ->label('Stock mínimo')
                    ->numeric()
                    ->nullable(),

                TextInput::make('proveedor')
                    ->label('Proveedor')
                    ->nullable()
                    ->maxLength(255),

                TextInput::make('lote')
                    ->label('Lote')
                    ->nullable()
                    ->maxLength(100),

                DatePicker::make('fecha_vencimiento')
                    ->label('Fecha de vencimiento')
                    ->nullable(),

                Select::make('responsable_id')
                    ->label('Responsable')
                    ->relationship('responsable', 'name')
                    ->searchable()
                    ->nullable(),
                
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true)
            ]);
    }
}
