<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'required' => 'El campo :attribute es obligatorio.',
    'regex' => 'El formato del campo :attribute es inválido.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'min' => [
        'numeric' => 'El campo :attribute debe ser mayor o igual a :min.',
    ],
    'date' => 'El campo :attribute no es una fecha válida.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha igual o posterior a hoy.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'data.nombre' => [
            'regex' => 'Solo se permiten letras, espacios y guiones',
            'required' => 'El nombre es obligatorio',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'data.nombre' => 'nombre',
    ],

];
