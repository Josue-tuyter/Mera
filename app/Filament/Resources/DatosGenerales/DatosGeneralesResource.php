<?php

namespace App\Filament\Resources\DatosGenerales;

use App\Filament\Resources\DatosGenerales\Pages\CreateDatosGenerales;
use App\Filament\Resources\DatosGenerales\Pages\EditDatosGenerales;
use App\Filament\Resources\DatosGenerales\Pages\ListDatosGenerales;
use App\Filament\Resources\DatosGenerales\Schemas\DatosGeneralesForm;
use App\Filament\Resources\DatosGenerales\Tables\DatosGeneralesTable;
use App\Models\DatosGenerales;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DatosGeneralesResource extends Resource
{
    protected static ?string $model = DatosGenerales::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static string | UnitEnum | null $navigationGroup = 'Configuración';
    
    protected static ?string $recordTitleAttribute = 'Datos Generales';

    public static function form(Schema $schema): Schema
    {
        return DatosGeneralesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DatosGeneralesTable::configure($table);
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
            'index' => ListDatosGenerales::route('/'),
            'create' => CreateDatosGenerales::route('/create'),
            'edit' => EditDatosGenerales::route('/{record}/edit'),
        ];
    }
}
