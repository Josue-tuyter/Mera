<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Avatar del usuario basado en el nombre
                ImageColumn::make('avatar_url') // Si no tienes campo, Filament intentará usar el avatar por defecto
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=FFFFFF&background=4E2C0F')
                    ->size(40),

                // Nombre con estilo destacado
                TextColumn::make('name')
                    ->label('Nombre Completo')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary'),

                // Email con icono y funcionalidad de copiar
                TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->icon('heroicon-m-envelope')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Correo copiado')
                    ->description('Verificado'),

                // Estado de verificación visual
                IconColumn::make('email_verified_at')
                    ->label('Estado')
                    ->boolean()
                    ->getStateUsing(fn ($record) => filled($record->email_verified_at))
                    ->trueIcon('heroicon-s-shield-check')
                    ->falseIcon('heroicon-s-shield-exclamation')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->alignCenter(),

                // Fechas formateadas
                TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime('d M, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),

                TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime('d M, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),
            ])
            ->filters([
                // Filtro para ver solo verificados
                Filter::make('verified')
                    ->label('Solo verificados')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                
                // Filtro para ver solo pendientes
                Filter::make('unverified')
                    ->label('Pendientes de verificación')
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->icon('heroicon-m-trash')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc');
    }
}