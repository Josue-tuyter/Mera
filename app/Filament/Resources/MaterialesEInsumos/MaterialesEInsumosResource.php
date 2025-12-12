<?php

namespace App\Filament\Resources\MaterialesEInsumos;

use App\Filament\Resources\MaterialesEInsumos\Pages\CreateMaterialesEInsumos;
use App\Filament\Resources\MaterialesEInsumos\Pages\EditMaterialesEInsumos;
use App\Filament\Resources\MaterialesEInsumos\Pages\ListMaterialesEInsumos;
use App\Filament\Resources\MaterialesEInsumos\Schemas\MaterialesEInsumosForm;
use App\Filament\Resources\MaterialesEInsumos\Tables\MaterialesEInsumosTable;
use App\Models\MaterialesEInsumos;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaterialesEInsumosResource extends Resource
{
    protected static ?string $model = MaterialesEInsumos::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string | UnitEnum | null $navigationGroup = 'Manejo de recursos';

    protected static ?string $recordTitleAttribute = 'Materiales e Insumos';

    public static function form(Schema $schema): Schema
    {
        return MaterialesEInsumosForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaterialesEInsumosTable::configure($table);
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
            'index' => ListMaterialesEInsumos::route('/'),
            'create' => CreateMaterialesEInsumos::route('/create'),
            'edit' => EditMaterialesEInsumos::route('/{record}/edit'),
        ];
    }
}
