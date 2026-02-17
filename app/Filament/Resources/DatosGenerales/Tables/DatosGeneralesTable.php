<?php

namespace App\Filament\Resources\DatosGenerales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;

class DatosGeneralesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Identidad de la Finca
                ImageColumn::make('logo_finca')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(url('/images/logo.png'))
                    ->size(40),

                TextColumn::make('nombre_finca')
                    ->label('Finca')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->color('primary')
                    ->description(fn ($record) => "Variedad: " . ($record->variedad_cacao ?? 'No definida')),

                TextColumn::make('propietario')
                    ->label('Propietario')
                    ->icon('heroicon-m-user-circle')
                    ->toggleable()
                    ->searchable(),

                // Datos Técnicos con Suffix y Badges
                TextColumn::make('area_hectareas')
                    ->label('Área')
                    ->suffix(' ha')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-m-map'),

                TextColumn::make('altitud_m')
                    ->label('Altitud')
                    ->suffix(' msnm')
                    ->icon('heroicon-m-chevron-double-up') // Cambio de icono para evitar errores
                    ->toggleable()
                    ->color('gray'),

                // CORRECCIÓN DEL ICONO ORGÁNICO
                IconColumn::make('certificado_organico')
                    ->label('Orgánico')
                    ->boolean()
                    ->trueIcon('heroicon-m-check-badge') // Usamos check-badge que existe en Solid/Mini
                    ->falseIcon('heroicon-m-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter()
                    ->toggleable(),

                // Contacto agrupado
                TextColumn::make('contacto_email')
                    ->label('Contacto')
                    ->icon('heroicon-m-envelope')
                    ->description(fn ($record) => "Tel: " . ($record->telefono ?? 'N/A'))
                    ->toggleable()
                    ->copyable(),

                TextColumn::make('ubicacion')
                    ->label('Ubicación')
                    ->icon('heroicon-m-map-pin')
                    ->limit(30)
                    ->wrap()
                    ->toggleable()
                    ->color('gray'),

                TextColumn::make('lluvia_media_mm')
                    ->label('Lluvia')
                    ->suffix(' mm')
                    ->icon('heroicon-m-cloud') // Cloud es más seguro en compatibilidad
                    ->toggleable()
                    ->color('info'),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Eliminar Datos Generales')
                        ->modalDescription('¿Está seguro de que desea eliminar los datos generales? Esta es una acción crítica.'),
                ]),
            ])
            ->paginated([10])
            ->striped();
    }
}