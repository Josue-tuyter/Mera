<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // 1. Cambia el título de la sección en el menú lateral
    protected static ?string $navigationLabel = 'Estructura organizacional';

    // 2. Cambia el nombre en singular (ej. para el botón "Crear...")
    protected static ?string $modelLabel = 'Usuaraio';

    // 3. Cambia el nombre en plural (ej. el título principal de la tabla)
    protected static ?string $pluralModelLabel = 'Estructura organizacional';

    // Opcional: Si quieres que el icono coincida con "Estructura"
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string | UnitEnum | null $navigationGroup = 'Configuración';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            //'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
