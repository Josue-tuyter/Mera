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
use Illuminate\Support\Carbon;

class Historial extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Historial de actividades';
    protected static string | UnitEnum | null $navigationGroup = 'Reportes';
    protected static ?string $title = 'Historial de actividades';

    protected string $view = 'filament.pages.historial';

    /**
     * Ocupar todo el ancho de la pantalla
     */
    public function getMaxContentWidth(): string
    {
        return 'full';
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                RegistroDeAtividades::query()->latest()
            )
            ->columns([
                // Fecha con icono y descripción humana (hace cuánto tiempo)
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime('d/m/Y')
                    ->description(fn ($record) => $record->created_at->diffForHumans())
                    ->icon('heroicon-m-calendar-days')
                    ->sortable()
                    ->color('gray'),

                // Tipo de actividad destacado
                Tables\Columns\TextColumn::make('tipo_actividad')
                    ->label('Actividad Realizada')
                    ->searchable()
                    ->weight('bold')
                    ->color('primary')
                    ->icon('heroicon-m-bolt')
                    ->formatStateUsing(fn ($state) => ucfirst($state)),

                // Duración con Badge de color según el tiempo
                Tables\Columns\TextColumn::make('duracion_minutos')
                    ->label('Esfuerzo / Duración')
                    ->suffix(' minutos')
                    ->badge()
                    ->icon('heroicon-m-clock')
                    ->color(fn ($state) => 
                        $state > 120 ? 'danger' :  // Más de 2 horas: Rojo
                        ($state > 60 ? 'warning' : 'success') // Más de 1 hora: Naranja, menos: Verde
                    )
                    ->sortable()
                    ->alignCenter(),

                // Columna extra: Hora exacta (Toggleable)
                Tables\Columns\TextColumn::make('hora')
                    ->label('Hora Exacta')
                    ->getStateUsing(fn ($record) => $record->created_at->format('H:i A'))
                    ->icon('heroicon-m-bell')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50])
            ->striped()
            ->emptyStateIcon('heroicon-o-archive-box-x-mark')
            ->emptyStateHeading('No hay registros en el historial');
    }
}