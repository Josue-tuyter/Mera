<?php

namespace App\Filament\Resources\Estados;

use App\Filament\Resources\Estados\Pages\CreateEstado;
use App\Filament\Resources\Estados\Pages\EditEstado;
use App\Filament\Resources\Estados\Pages\ListEstados;
use App\Filament\Resources\Estados\Schemas\EstadoForm;
use App\Filament\Resources\Estados\Tables\EstadosTable;
use App\Models\Estado;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Forms; // Esto es vital para que Forms\Form funcione
// Asegúrate de que estas líneas estén presentes si el error persiste


class EstadoResource extends Resource
{
    protected static ?string $model = Estado::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-check-badge';

    protected static string | UnitEnum | null $navigationGroup = 'Gestión de actividades';

    protected static ?string $recordTitleAttribute = 'Estado de Actividades';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components(
                \App\Filament\Resources\Estados\Schemas\EstadoForm::configure($schema)
            );
    }

    public static function table(Table $table): Table
    {
        return EstadosTable::configure($table);
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
            'index' => ListEstados::route('/'),
            'create' => CreateEstado::route('/create'),
            //'edit' => EditEstado::route('/{record}/edit'),
        ];
    }
}
