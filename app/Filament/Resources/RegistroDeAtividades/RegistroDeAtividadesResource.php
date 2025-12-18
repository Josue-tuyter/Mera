<?php

namespace App\Filament\Resources\RegistroDeAtividades;

use App\Filament\Resources\RegistroDeAtividades\Pages\CreateRegistroDeAtividades;
use App\Filament\Resources\RegistroDeAtividades\Pages\EditRegistroDeAtividades;
use App\Filament\Resources\RegistroDeAtividades\Pages\ListRegistroDeAtividades;
use App\Filament\Resources\RegistroDeAtividades\Schemas\RegistroDeAtividadesForm;
use App\Filament\Resources\RegistroDeAtividades\Tables\RegistroDeAtividadesTable;
use App\Models\RegistroDeAtividades;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RegistroDeAtividadesResource extends Resource
{
    protected static ?string $model = RegistroDeAtividades::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string | UnitEnum | null $navigationGroup = 'Gestión de actividades';
    
    protected static ?string $recordTitleAttribute = 'Registro de Atividades';

    public static function form(Schema $schema): Schema
    {
        return RegistroDeAtividadesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RegistroDeAtividadesTable::configure($table);
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
            'index' => ListRegistroDeAtividades::route('/'),
            'create' => CreateRegistroDeAtividades::route('/create'),
            'edit' => EditRegistroDeAtividades::route('/{record}/edit'),
        ];
    }
}
