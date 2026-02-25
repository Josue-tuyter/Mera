<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                
                // SECCIÓN 1: PERFIL - FONDO MARRÓN CACAO
                Section::make('Información del Perfil')
                    ->description('Datos básicos de identidad del usuario.')
                    ->icon('heroicon-o-user-circle')
                    ->extraAttributes([
                        'class' => 'bg-[#4E2C0F]/5 border-t-4 border-[#4E2C0F] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        Group::make([
                            TextInput::make('name')
                                ->label('Nombre Completo')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('Ej: Juan Pérez')
                                ->regex('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/')
                                ->validationMessages([
                                    'regex' => 'El nombre solo puede contener letras y espacios',
                                ])
                                ->live(),

                            TextInput::make('email')
                                ->label('Correo Electrónico')
                                ->email()
                                ->required()
                                ->maxLength(100)
                                ->placeholder('usuario@empresa.com')
                                ->live(onBlur: true)
                                ->rules([
                                    'email:rfc,dns',
                                    'not_regex:/@(mailinator|tempmail|guerrillamail|10minutemail|yopmail|dispostable|throwawaymail|fakeinbox|sharklasers|getnada)\./i',
                                ])
                                ->validationMessages([
                                    'email' => 'El formato no es válido o el dominio no existe',
                                    'not_regex' => 'No se permiten correos temporales',
                                ]),
                        ])->columnSpan(2),
                    ])
                    ->columns(2),

                // SECCIÓN 2: SEGURIDAD - FONDO VERDE FOLLAJE
                Section::make('Seguridad de la Cuenta')
                    ->description('Gestión de credenciales y acceso.')
                    ->icon('heroicon-o-lock-closed')
                    ->extraAttributes([
                        'class' => 'bg-[#606C38]/5 border-t-4 border-[#606C38] rounded-xl shadow-sm',
                    ])
                    ->schema([
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->revealable()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->maxLength(100)
                            ->placeholder('••••••••')
                            ->helperText('Mínimo 8 caracteres, incluye mayúsculas y números.')
                            ->live(onBlur: true)
                            ->rules([
                                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                            ])
                            ->validationMessages([
                                'required' => 'La contraseña es obligatoria',
                                'min' => 'Debe tener al menos 8 caracteres',
                                'regex' => 'Debe contener mayúscula, minúscula y un número',
                            ])
                            // Evita sobreescribir la contraseña si se deja en blanco al editar
                            ->dehydrated(fn ($state) => filled($state))
                            

                        // Podrías añadir aquí un Select de "Rol" o "Estado" en el futuro
                    ])
                    ->columns(2),
            ]);
    }
}