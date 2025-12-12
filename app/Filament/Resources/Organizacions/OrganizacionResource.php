<?php

namespace App\Filament\Resources\Organizacions;

use App\Filament\Resources\Organizacions\Pages\CreateOrganizacion;
use App\Filament\Resources\Organizacions\Pages\EditOrganizacion;
use App\Filament\Resources\Organizacions\Pages\ListOrganizacions;
use App\Filament\Resources\Organizacions\Schemas\OrganizacionForm;
use App\Filament\Resources\Organizacions\Tables\OrganizacionsTable;
use App\Models\Organizacion;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrganizacionResource extends Resource
{
    protected static ?string $model = Organizacion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Gestión de actividades';

    protected static ?string $recordTitleAttribute = 'Organizacion de tareas';

    public static function form(Schema $schema): Schema
    {
        return OrganizacionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizacionsTable::configure($table);
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
            'index' => ListOrganizacions::route('/'),
            'create' => CreateOrganizacion::route('/create'),
            'edit' => EditOrganizacion::route('/{record}/edit'),
        ];
    }
}
