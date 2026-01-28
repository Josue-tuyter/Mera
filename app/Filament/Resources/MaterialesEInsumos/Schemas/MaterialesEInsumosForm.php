<?php

namespace App\Filament\Resources\MaterialesEInsumos\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;

class MaterialesEInsumosForm
{

    protected static function validateField(
        $livewire,
        string $field,
        $value,
        array $rules,
        array $messages
    ): void {
        // Limpia errores previos
        $livewire->resetErrorBag("data.$field");

        foreach ($rules as $rule) {

            if ($rule === 'required' && blank($value)) {
                $livewire->addError("data.$field", $messages['required']);
                return;
            }

            if ($rule === 'numeric' && ! is_numeric($value)) {
                $livewire->addError("data.$field", $messages['numeric']);
                return;
            }

            if ($rule === 'email' && ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $livewire->addError("data.$field", $messages['email']);
                return;
            }

            if (str_starts_with($rule, 'regex:')) {
                $pattern = substr($rule, 6);

                if (! preg_match($pattern, $value)) {
                    $livewire->addError("data.$field", $messages['regex']);
                    return;
                }
            }

            if (str_starts_with($rule, 'min:')) {
                $min = (int) substr($rule, 4);

                if (strlen($value) < $min) {
                    $livewire->addError("data.$field", $messages['min']);
                    return;
                }
            }
        }
    }




    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn ($state, $livewire) =>
                        self::validateField(
                            $livewire,
                            'nombre',
                            $state,
                            ['required', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/'],
                            [
                                'required' => 'El nombre es obligatorio',
                                'regex'    => 'Solo se permiten letras y espacios',
                            ]
                        )
                    )
                    ->required(),

                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->maxLength(500)
                    ->rows(3)
                    ->nullable()
                    ->helperText('Máximo 500 caracteres'),

                TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->rules([
                        'required',
                        'numeric',
                        'min:0',
                    ])
                    ->validationMessages([
                        'numeric' => 'Debe ser un número',
                        'min' => 'No puede ser negativo',
                    ]),

                TextInput::make('unidad')
                    ->label('Unidad')
                    ->nullable()
                    ->required()
                    ->maxLength(30)
                    ->regex('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/')
                    ->live(onBlur: true)
                    ->validationMessages([
                        'regex' => 'Solo se permiten letras, espacios y guiones',
                    ]),

                TextInput::make('stock_minimo')
                    ->label('Stock mínimo')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(999999)
                    ->nullable(),

                TextInput::make('proveedor')
                    ->label('Proveedor')
                    ->nullable()
                    ->maxLength(100)
                    ->required()
                    ->reactive()
                    ->debounce(600)
                    ->rules([
                        'nullable',
                        'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/',
                    ])
                    ->validationMessages([
                        'regex' => 'Formato inválido',
                    ])
                    ,

                TextInput::make('lote')
                    ->label('Lote')
                    ->nullable()
                    ->maxLength(50)
                    ->regex('/^[a-zA-Z0-9\-\/]+$/')
                    ->validationMessages([
                        'regex' => 'Solo se permiten letras, números, guiones y barras',
                    ])
                    ->live(),

                DatePicker::make('fecha_vencimiento')
                    ->label('Fecha de vencimiento')
                    ->nullable()
                    ->reactive()
                    ->minDate(today())
                    ->rules([
                        'nullable',
                        'date',
                        'after_or_equal:today',
                    ])
                    ->validationMessages([
                        'after_or_equal' => 'No se permiten fechas pasadas',
                    ]),

                Select::make('responsable_id')
                    ->label('Responsable')
                    ->relationship('responsable', 'name')
                    ->nullable(),
            ]);
    }
}