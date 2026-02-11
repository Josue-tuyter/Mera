<?php

namespace App\Filament\Widgets;

use App\Models\MaterialesEInsumos;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AlertasInventario extends BaseWidget
{
    protected static bool $isLazy = false;
    protected static ?string $heading = 'Insumos que requieren reabastecimiento';
    protected int | string | array $columnSpan = 'full'; // Ocupa todo el ancho

    public function table(Table $table): Table
    {
        return $table
            ->query(MaterialesEInsumos::whereColumn('stock', '<=', 'stock_minimo'))
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->weight('bold'),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock Actual')
                    ->badge()
                    ->color('danger'),
                Tables\Columns\TextColumn::make('stock_minimo')->label('Mínimo Requerido'),
                Tables\Columns\TextColumn::make('unidad'),
                Tables\Columns\TextColumn::make('proveedor'),
            ]);
    }
}