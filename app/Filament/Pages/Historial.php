<?php

namespace App\Filament\Pages;

use App\Models\RegistroDeAtividades;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use UnitEnum;


class Historial extends Page implements HasTable
{
      use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Historial de actividades';
    protected static string | UnitEnum | null $navigationGroup = 'Reportes';
    protected static ?string $title = 'Historial de actividades';

    protected string $view = 'filament.pages.historial';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                RegistroDeAtividades::query()->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tipo_actividad')
                    ->label('Tipo de actividad')
                    ->searchable(),

                Tables\Columns\TextColumn::make('duracion_minutos')
                    ->label('Duración')
                    ->suffix(' min'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }


    //protected string $view = 'filament.pages.historial';
}
