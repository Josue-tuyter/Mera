<?php

namespace App\Filament\Pages;

use BackedEnum;
use UnitEnum;
use App\Filament\Widgets\ResumenStock;
use App\Filament\Widgets\AlertasInventario;
use Filament\Pages\Page;


class CentroControl extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Control de stock';
    protected static string|UnitEnum|null $navigationGroup = 'Stock e insumos';
    protected static ?string $title = 'Stock e insumos';
    protected string $view = 'filament.pages.centro-control';


    // Aquí vinculamos los widgets a esta página específica
    protected function getHeaderWidgets(): array
    {
        return [    
            ResumenStock::class,    
            AlertasInventario::class,
        ];
    }



}
