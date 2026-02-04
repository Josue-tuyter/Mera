<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(100)
                    ->regex('/^[a-zA-Záéíóúñ\\s]+$/')
                    ->validationMessages([
                        'regex' => 'El nombre solo puede contener letras y espacios',
                    ])
                    ->live(),

                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->maxLength(100)
                    ->nullable()
                    ->required()
                    ->live(onBlur: true)
                    ->rules([
                        'nullable',
                        'email:rfc,dns',
                        'not_regex:/@(mailinator|tempmail|guerrillamail|10minutemail|yopmail|dispostable|throwawaymail|fakeinbox|sharklasers|getnada)\./i',
                    ])
                    ->validationMessages([
                        'email' => 'El correo electrónico no tiene un formato válido o el dominio no existe',
                        'not_regex' => 'No se permiten correos temporales',
                    ]) ,

                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required()
                    ->revealable()
                    ->required()
                    ->minLength(8)
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->rules([
                        'required',
                        'min:8',
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                    ])
                    ->validationMessages([
                        'required' => 'La contraseña es obligatoria',
                        'min' => 'La contraseña debe tener al menos 8 caracteres',
                        'regex' => 'Debe contener al menos una mayúscula, una minúscula y un número',
                    ])
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    ->visibleOn('create')
                    ->visibleOn('edit')
            ]);
    }
}
