<?php

namespace App\Filament\Resources\EquiposYHerramientas;

use App\Filament\Resources\EquiposYHerramientas\Pages\CreateEquiposYHerramienta;
use App\Filament\Resources\EquiposYHerramientas\Pages\EditEquiposYHerramienta;
use App\Filament\Resources\EquiposYHerramientas\Pages\ListEquiposYHerramientas;
use App\Filament\Resources\EquiposYHerramientas\Schemas\EquiposYHerramientaForm;
use App\Filament\Resources\EquiposYHerramientas\Tables\EquiposYHerramientasTable;
use App\Models\EquiposYHerramienta;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EquiposYHerramientaResource extends Resource
{
    protected static ?string $model = EquiposYHerramienta::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string | UnitEnum | null $navigationGroup = 'Manejo de recursos';

    protected static ?string $recordTitleAttribute = 'Equipos y Herramientas';

    public static function form(Schema $schema): Schema
    {
        return EquiposYHerramientaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EquiposYHerramientasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEquiposYHerramientas::route('/'),
            'create' => CreateEquiposYHerramienta::route('/create'),
            'edit' => EditEquiposYHerramienta::route('/{record}/edit'),
        ];
    }
}
