<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Notifications\WelcomeUserNotification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Variable para guardar la clave en texto plano
    public string $plainPassword = '';

    /**
     * Este método se ejecuta justo antes de validar y crear.
     * Es el mejor lugar para robar la contraseña antes de que se encripte.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Guardamos la clave real en nuestra variable de clase
        $this->plainPassword = $data['password'];

        return $data;
    }

    /**
     * Después de que el registro existe en la base de datos,
     * enviamos el correo usando la variable que guardamos arriba.
     */
    protected function afterCreate(): void
    {
        if (!empty($this->plainPassword)) {
            $this->record->notify(new WelcomeUserNotification($this->plainPassword));
        }
    }
}