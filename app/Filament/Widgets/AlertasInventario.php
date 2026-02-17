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
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(MaterialesEInsumos::whereColumn('stock', '<=', 'stock_minimo'))
            ->paginated(false) // Para que se vea limpio como widget
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->weight('bold')
                    ->color('primary'),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock Actual')
                    ->badge()
                    ->color('danger'),
                Tables\Columns\TextColumn::make('stock_minimo')
                    ->label('Mínimo Requerido')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('unidad')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('proveedor')
                    ->icon('heroicon-m-truck'),
            ]);
    }
}